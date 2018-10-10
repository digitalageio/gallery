<?php 
class UserController extends BaseController {

/* Permissions */
    public function checkIsAdmin(){
        $user = User::find(Auth::user()->id)->first();
        $permissions = Permissions::where('user_id','=',$user->id)
                                            ->where('is_admin','=','1')
                                            ->first();
        $account = Account::where('id','=',$permissions->account_id)->first();
        if($account->count()){
            return $account;
        }
        return false;
    } 

    public function checkIsManager(){
        $user = User::find(Auth::user()->id)->first();
        $permissions = Permissions::where('user_id','=',$user->id)
                                        ->where(function($query){
                                                 $query->where('is_admin','=','1')
                                                 ->orWhere('is_manager','=','1');
                                             })->first();
        $account = Account::where('id','=',$permissions->account_id)->first();
        if($account->count()){
            return $account;
        }
        return false;
    }

    public function checkIsDonor(){
        $user = User::find(Auth::user()->id)->first();
        $permissions = Permissions::where('user_id','=',$user->id)
                                        ->where(function($query){
                                                 $query->where('is_admin','=','1')
                                                 ->orWhere('is_manager','=','1')
                                                 ->orWhere('is_donor','=','1');
                                             })->first();
        $account = Account::where('id','=',$permissions->account_id)->first();
        if($account->count()){
            return $account;
        }
        return false;
    } 
/* /Permissions */


    public function permissionCheck($level){

        $user = Auth::user();
        switch($level){
            case 'admin':
                $permissions = Permissions::where('user_id','=',$user->id)
                                        ->where('is_admin','=','1')
                                        ->first();
            break;
            case 'manager':
                $permissions = Permissions::where('user_id','=',$user->id)
                                    ->where(function($query){
                                             $query->where('is_admin','=','1')
                                             ->orWhere('is_manager','=','1');
                                         })->first();
            break;
            case 'donor':
                $permissions = Permissions::where('user_id','=',$user->id)
                                    ->where(function($query){
                                             $query->where('is_admin','=','1')
                                             ->orWhere('is_manager','=','1')
                                             ->orWhere('is_donor','=','1');
                                         })->first();
            break;
            default:
                $permissions = Permissions::where('user_id','=',$user->id)
                                    ->where(function($query){
                                             $query->where('is_admin','=','1')
                                             ->orWhere('is_manager','=','1')
                                             ->orWhere('is_donor','=','1');
                                         })->first();               
            break;
        }
        $account = Account::where('id','=',$permissions->account_id)->first();
        if($account->count()){
            return $account;
        }
        return false;
    }

/* Forgotten password */
    public function getForgotPassword() {
        return View::make('user.forgot');
    }

    public function postForgotPassword(){
        $validator = Validator::make(Input::all(),
                array(
                    'email' => 'required|email'
                ));

        if($validator->fails()){
            return Redirect::route('user-forgot-password')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = User::where('email', '=', Input::get('email'));

            if($user->count()){
                $user = $user->first();

                $code = str_random(60);
                $password = str_random(10);

                $user->code = $code;
                $user->password_temp = Hash::make($password);

                if($user->save()){
                    Mail::send('emails.auth.forgot', array(
                                'link' => URL::route('user-recover', $code),
                                'username' => $user->username,
                                'password' => $password
                                ), function($message) use ($user) {
                                    $message->to($user->email,$user->username)->subject('Password reset');
                            });

                    return Redirect::route('home')
                        ->with('global','An email containing your new password has been sent.');
                }
            }
        }
        return Redirect::route('user-forgot-password')
            ->with('global','Password recovery failed.');
    }

    public function getRecover($code) {
        $user = User::where('code', '=', $code)
            ->where('password_temp', '!=', '');

        if($user->count()){
            $user = $user->first();
            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code = '';

            if($user->save()){
                return Redirect::route('home')
                    ->with('global','Your password has been successfully reset. You may now sign in with your new password.');
            }
        }

        return Redirect::route('home')
            ->with('global','System error. Password recovery failed.');

    }

/* User creation */
    public function getCreate() {
        return View::make('user.create');
    }

    public function postCreate() {

        $validator = Validator::make(Input::all(), 
                array(
                        'email' => 'required|max:50|email|unique:users',
                        'username' => 'required|max:25|min:3|unique:users',
                        'password' => 'required|min:6',
                        'password_again' => 'required|same:password'
                )
        );

        if($validator->fails()){
            return Redirect::route('user-create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $email = Input::get('email');
            $username = Input::get('username');
            $password = Input::get('password');

            //Activation code
            $code = str_random(60);

            $user = User::create(array(
                        'email' => $email,
                        'username' => $username,
                        'password' => Hash::make($password)
                        //'code' => $code
                        ));
            if($user) {
                /*
                Mail::send('emails.auth.activate', array('link' => URL::route('user-activate', $code), 'username' => $username), function($message) use ($user) {
                       $message->to($user->email,$user->username)->subject("Activate your donors.io user.");
                });
                */
                return Redirect::route('home')
                    ->with('global', 'Your user has been created and you may now sign in.');
            }
        }
    }

/* Account activation */
    public function getActivate($code){
        $user = User::where('code', '=', $code)->where('active', '=', 0);

        if($user->count()) {
            $user = $user->first();
            $user->active = 1;
            $user->code = '';

            if($user->save()){
                return Redirect::route('home')
                    ->with('global','Account activated. You may now sign in.');
            }
        }

        return Redirect::route('home')
            ->with('global', 'Account activation failed. Please try again later.');
    }

/* Sign in/sign out */
    public function getSignIn(){
        return View::make('user.sign-in');
    }

    public function getSignOut(){
        Auth::logout();
        return Redirect::route('home');
    }

    public function postSignIn(){
        $validator = Validator::make(Input::all(),
            array(
                    'username' => 'required',
                    'password' => 'required'
                 )
            );
        
        if($validator->fails()){
            return Redirect::route('home')
                ->withErrors($validator)
                ->withInput();
        } else {
    
            $remember = (Input::has('remember') ? true : false);

            $auth = Auth::attempt(array(
                        'username' => Input::get('username'),
                        'password' => Input::get('password')
                        //'active' => 1
                        ), $remember);

            if($auth) {
                $user = Auth::user();
                return Redirect::intended('/');
            } else {
                return View::make('home')
                    ->with('global','The username and password combination is incorrect.');
            }
        }

                return View::make('home')
            ->with('global','There was a problem signing you in.');
    }

/* Get settings page */
    public function getChangeSettings(){
        $user = Auth::user();
        return View::make('user.settings', array('user'=>$user));
    }

/* Change general settings */
    public function postChangeInfo(){
       $validator = Validator::make(Input::all(),
                array(
                    'first_name' => 'max:50',
                    'last_name' => 'max:50',
                    'address' => 'max:100',
                    'city' => 'max:50',
                    'state' => 'max:2|min:2',
                    'zipcode' => 'max:5|min:5',
                    'phone_number' => 'max:10|min:10'
                    )
              );

      if($validator->fails()) {
            return Redirect::route('user-change-settings')
                ->withErrors($validator);   
      } else {
            $user = Auth::user();

            foreach(Input::except('_token') as $key => $value){
                if(Input::has($key)){
                    $user[$key] = Input::get($key);
                }
            }


            if($user->save()){
                        return Redirect::route('user-change-settings')
                            ->with('global','Your settings have been changed.');
            } else {
                        return Redirect::route('user-change-settings')
                            ->with('global','System error. Your settings have not been changed.');
            }                
        }
      
        return Redirect::route('user-change-settings')
            ->with('global','System error. Your settings have not been changed.');
    }

public function postChangeFinancialSettings(){

}

public function postChangeIcon(){
       $validator = Validator::make(Input::all(),
                array(
                    'profile_icon' => 'image|required|max:250'
                    )
              );

      if($validator->fails()) {
            return Redirect::route('user-change-settings')
                ->withErrors($validator);   
      } else {
            $user = Auth::user();
            if(Input::hasFile('profile_icon')){
                $file = Input::file('profile_icon');
                $directoryPath = 'uploads/users/' . $user->username . "/";
                $filename = $file->getClientOriginalName();
                if(File::isDirectory($directoryPath)){
                    File::cleanDirectory($directoryPath);
                }
                Input::file('profile_icon')->move($directoryPath, $filename);
                $user->profile_icon = $filename;
                $user->save();
            }


            if($user){
                        return Redirect::route('user-change-settings')
                            ->with('global','Your settings have been changed.');
            } else {
                        return Redirect::route('user-change-settings')
                            ->with('global','System error. Your settings have not been changed.');
            }                
        }
}

/* Change password */
    public function postChangePassword(){
       $validator = Validator::make(Input::all(),
              array(
                 'old_password'     => 'required_with:password,password_confirm', 
                 'password'         => 'required_with:old_password,password_confirm|min:6', 
                 'password_confirm' => 'required_with:old_password,password|same:password'
                 )
              );

      if($validator->fails()) {
            return Redirect::route('user-change-settings')
                ->withErrors($validator);   
      } else {
            $user = User::find(Auth::user()->id);

            if(Input::has('old_password') && Input::has('password')){
                $old_password = Input::get('old_password');
                $password = Input::get('password');

                if(Hash::check($old_password, $user->getAuthPassword())){
                    $user->password = Hash::make($password);

                    if($user->save()){
                        return Redirect::route('user-change-settings')
                            ->with('global','Your password been changed.');
                    } else {
                            return Redirect::route('user-change-settings')
                                ->with('global','System error. Your password has not been changed.');
                    }
                }
            }
        }
      
        return Redirect::route('user-change-settings')
            ->with('global','System error. Your password has not been changed.');
    }

    public function getAddUser(){
    $user = User::find(Auth::user()->id);
        return View::make('user.create',array('manual' => true,'user' => $user,'title'=>'Create a User'));
    }

public function postAddUser() {

        if($this->isAdmin()){
            $account = $this->isAdmin();
        } elseif($this->isManager()){
            $account = $this->isManager();
        }

        $validator = Validator::make(Input::all(), 
                array(
                        'email' => 'max:50|email|unique:users',
                        'username' => 'required|max:25|min:3|unique:users',
                        'password' => 'required|min:6',
                        'password_again' => 'required|same:password',
                )
        );

        if($validator->fails()){
            return Redirect::route('user-create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $email = Input::get('email');
            $username = Input::get('username');
            $password = Input::get('password');

            $newuser = User::create(array(
                        'email' => $email,
                        'username' => $username,
                        'password' => Hash::make($password)
                        //'code' => $code
                        ));
            if($newuser) {

                $params = array();

                if(Input::has('is_manager')){
                    $params['is_manager']  = '1';
                } else $params['is_manager'] = '0';
                $params['is_admin'] = '0';
                $params['is_donor'] = '1';
                $params['user_id'] = $newuser->id;
                $params['account_id'] = $account->id;

                $permissions = DB::table('permissions')->insertGetId($params);
                /*
                Mail::send('emails.auth.activate', array('link' => URL::route('user-activate', $code), 'username' => $username), function($message) use ($newuser) {
                       $message->to($newuser->email,$newuser->username)->subject("You've been registered at donors.io!");
                });
                */
                if($permissions){
                    return Redirect::route('user-add-user-manual')
                       ->with('global', 'New user created.');
                } else {
                    return Redirect::route('user-add-user-manual')
                        ->with('global', 'User creation failed.');
                }
            }
        }
                    return Redirect::route('user-add-user-manual')
                        ->with('global', 'User creation failed.');
    }

    public function postUserList(){
        $user = Auth::user();
        $account = $this->permissionCheck('manager');
        $userlist = $account->users;
        return View::make('user.list',array('userlist' => $userlist,'user' => $user,'account'=>$account));
    }

    public function getUserList(){
        $user = Auth::user();       
        $account = $this->permissionCheck('manager');
       // if($account->count()){
        $userlist = $account->users;
        return View::make('user.list',array('userlist' => $userlist,'user' => $user,'account'=>$account));
       // } else return View::make('user.list',array('message' => 'No users found.'));    
    }

    public function getUserProfile($username){
        $account = $this->permissionCheck('manager');
        $asUser = User::where('username','=',$username)->first();
        return View::make('user.profile',array('asUser'=>$asUser,'lookup'=>$username,'account'=>$account));
    }

    public function getIframe($subdomain){
        $account = Account::where('subdomain','=',$subdomain)->first();
        return View::make('iframe',array('account' => $account));
    }

} //end class
