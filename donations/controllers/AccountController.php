<?php 
class AccountController extends BaseController {

public function getAccountId(){
    $user = Auth::user();
    $permissions = Permissions::where('user_id','=',$user->id)->where('is_admin','=','1')->first();
    $account = Account::where('id','=',$permissions->account_id)->first();

    return $account;
}

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

/* Account creation */
    public function getCreate() {
        $user = Auth::user();
        $permissions = Permissions::where('user_id','=',$user->id)->where('is_admin','=','1')->first();
        if(!empty($permissions)){
            $account = Account::where('id','=',$permissions->account_id)->first();
            return View::make('account.create', array('account' => $account,'user' => $user));
        }
        return View::make('account.create',array('user'=>$user));
    }

    public function postCreate() {

        $validator = Validator::make(Input::all(),
                array(
                        'support_email' => 'required|max:50|email|unique:accounts',
                        'name' => 'required|min:3|max:100|unique:accounts',
                        'subdomain' => 'required|max:25|min:3|unique:accounts'
                )
        );

        if($validator->fails()){
            return Redirect::route('create-account-post')
                ->withErrors($validator)
                ->withInput();
        } else {
            $support_email = Input::get('support_email');
            $name = Input::get('name');
            $subdomain = Input::get('subdomain');
            $user = Auth::user();

            $post = array(
                    'name' => Input::get('name')
                );

            $type = 'customers';
        $balanced_id = AccountsBalanced::createBalanced($type,$post);

        $account = Account::create(array(
                'support_email' => $support_email,
                'name' => $name,
                'subdomain' => $subdomain,
                ));

        $params = array(
                'is_admin' => '1',
                'is_manager' => '1',
                'is_donor' => '1'
        );

        $params['user_id'] = $user->id;
        $params['account_id'] = $account->id;

        $permissions = DB::table('account_user')->insertGetId($params);

            if($account->save()) {

                $balanced = AccountsBalanced::create(array(
                    'account_id' => $account->id,
                    'uri' => $balanced_id,
                    'type' => $type

                ));

                if($permissions){

                    return Redirect::route('create-account')
                        ->with('global', 'Your account has been created and an activation email has been sent to the email address you provided.');
                        //->withErrors();
                } else return Redirect::route('create-account')
                            ->with('global', 'Account permissions failed to be set.');

            } else return Redirect::route('create-account')
                        ->with('global', 'Account creation failed.');
                        //->withErrors();
        }

        //print_r(Input::all());
    }

    public function postCreateBankAccount(){
        $account = $this->permissionCheck('admin');
        $type = 'bank_accounts';
        $balanced = AccountsBalanced::create(array(
            'account_id' => $account->id,
            'uri' => $_POST['uri'],
            'type' => $type
        ));

        if($balanced->save()){
            $verify_url = AccountsBalanced::createVerification($balanced['uri']);
            $verify = AccountsBalanced::cURLBalanced($verify_url,false);
            if($verify){
                $verification = AccountsBalanced::create(array(
                    'account_id' => $account->id,
                    'uri' => $verify['bank_account_verifications'][0]['href'],
                    'type' => 'verifications'
                ));
                if($verification->save()){
                    return $verification['uri'];
                }
                return $balanced['uri'] . ' ' . $verify_url;
            } else return 'Application error. Verification failed to properly submit.';
        } else return 'Application error. New account information was not properly saved.';
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

/* Get settings page */
    public function getChangeSettings(){
        $user = Auth::user();
        $verified = array();
        $permissions = Permissions::where('user_id','=',Auth::user()->id)->first();
        if($permissions->is_admin){
            $account = Account::find($permissions->account_id);
            $verification = AccountsBalanced::where('account_id','=',$permissions->account_id)->where('type','=','verifications')->first();
            $verification_status = AccountsBalanced::fetchBalanced($verification['uri']);
            $status = $verification_status['bank_account_verifications'][0]['verification_status'];
            $deposit = $verification_status['bank_account_verifications'][0]['deposit_status'];
            if($deposit == 'succeeded' && $status == 'succeeded'){
                $verified = array('status' => true,'message' => 'The bank account information currently tethered to this donors.io account has been verified.');
            } else if($deposit == 'succeeded' && $status == 'pending'){
                $verified = array('status' => false,'message' => 'Please submit the values deposited to this bank account for verification.');
            }
        }
        $params = array('account' => $account,'user' => $user,'funds'=>$account->funds,'title'=>'Account Settings','verified'=>$verified);
        return View::make('account.settings',$params);
    }

/* Change general settings */
    public function postChangeGeneralSettings(){

            $account = $this->permissionCheck('admin');

            $namestr = "max:100|unique:accounts," . $account->id;
            $webstr = "max:50|unique:accounts," . $account->id;
            $emailstr = "max:100|unique:accounts," . $account->id;
       $validator = Validator::make(Input::all(),
                array(
                    'name' => "max:100|unique:accounts,id,{$account->id}",
                    'website_url' => 'max:50',
                    'support_email' => 'email|max:100',
                    'address' => 'max:100',
                    'city' => 'max:50',
                    'state' => 'max:2|min:2',
                    'zipcode' => 'max:5|min:5',
                    'phone_number' => 'max:10|min:10'
                    )
              );

      if($validator->fails()) {
            return Redirect::route('account-change-settings')
                ->withErrors($validator);   
      } else {

            foreach(Input::except('_token') as $key => $value){
                if(Input::has($key)){
                    $account->$key = Input::get($key);
                }
            }

            if($account->save()){
                        return Redirect::route('account-change-settings')
                            ->with('global','Your General settings have been changed.');
            } else {
                        return Redirect::route('account-change-settings')
                            ->with('global','System error. Your General settings have not been changed.');
            }                
        }
      
        return Redirect::route('account-change-settings')
            ->with('global','System error. Your General settings have not been changed.');
    }

    public function getFundList(){
        $account = $this->permissionCheck('donor');
        $funds = $account->funds;
        return View::make('account.listFunds',array('funds'=>$funds));
    }

/* Add fund */
    public function postAddFund(){
        $account = $this->permissionCheck('admin');
        $fund = Fund::create(array(
                'account_id' => $account->id,
                'name' => $_POST['name']
            ));
        if($fund->save()){
            $funds = $account->funds;
            return View::make('account.listFunds',array('funds'=>$funds));
        } else return 'System error.';
    }
 
 /* remove fund */
    public function postRemoveFund(){
        $account = $this->permissionCheck('admin');
        $fund = Fund::find($_POST['id']);
        if($fund->delete()){
            $funds = $account->funds;
            return View::make('account.listFunds',array('funds'=>$funds));
        } else return 'System error.';
    }     

/* Change icon */
    public function postChangeIcon(){

        $account = $this->getAccountId();

       $validator = Validator::make(Input::all(),
                array(
                    'logo' => 'image|max:250'
                    )
                );

      if($validator->fails()) {
            return Redirect::route('account-change-settings')
                ->withErrors($validator);   
      } else {

            $fund_taglist = array();
            $input = Input::except('logo','_token','fund_entry','fund_button');

            foreach($input as $key => $value){
                if(!empty($value)){
                    $fund_taglist[] = str_replace(",", "", $value);
                }
            }

            if(Input::hasFile('logo_filename')){
                $file = Input::file('logo_filename');
                $directoryPath = 'uploads/accounts/' . $account->subdomain . "/";
                $filename = $file->getClientOriginalName();
                if(File::isDirectory($directoryPath)){
                    cleanDirectory($directoryPath);
                }
                Input::file('logo_filename')->move($directoryPath, $filename);
                $account->logo_filename = $filename;
            }

            if($account->save()){
                        return Redirect::route('account-change-settings')
                            ->with('global','Your custom settings have been changed.');
            } else {
                        return Redirect::route('account-change-settings')
                            ->with('global','System error. Your custom settings have not been changed.');
            }     

        }
      
        return Redirect::route('account-change-settings')
            ->with('global','System error. Your custom settings have not been changed.');
    }

/* Change financial settings */
    public function postChangeFinancialSettings(){
        $validator = Validator::make(Input::all(),
                array(
                    'website_url' => 'active_url|unique:users',
                    'address' => '',
                    'city' => '',
                    'state' => '',
                    'zipcode' => '',
                    'custom_message' => '',
                    'logo_filename' => 'image',
                    'transaction_fee_option' => 'required',
                    'quarterly_statement_option' => 'required',
                    'phone_number' => ''
                    )
                );

            foreach(Input::except('token','old_password','password','password_confirm') as $key => $value){
                $user->$key = Input::get($key);
            }
    }

/* Change communication settings */
    public function postChangeCommunicationSettings(){

        $account = $this->getAccountId();

       $validator = Validator::make(Input::all(),
                array(
                    'custom_message' => 'max:1000'
                    )
              );

      if($validator->fails()) {
            return Redirect::route('account-change-settings')
                ->withErrors($validator);   
      } else {

            foreach(Input::except('_token') as $key => $value){
                $account->$key = $value;
            }

            if($account->save()){
                        return Redirect::route('account-change-settings')
                            ->with('global','Your communication settings have been changed.');
            } else {
                        return Redirect::route('account-change-settings')
                            ->with('global','System error. Your communication settings have not been changed.');
            }     

        }
      
        return Redirect::route('account-change-settings')
            ->with('global','System error. Your communication settings have not been changed.');
    }

    public function postSubmitAccountVerification(){
        $account = $this->getAccountId();
        $verification = AccountsBalanced::where('account_id','=',$account->id)->where('type','=','verifications')->first();
        $post = array('amount_1' => $_POST['amount_1'],'amount_2' => $_POST['amount_2']);
        $response = AccountsBalanced::attemptVerification($verification['uri'],$post);
        return $response['bank_account_verifications'][0]['verification_status'];
    }

/* Change payment settings */
    public function postChangePaymentSettings(){

        $account = $this->getAccountId();

        $validator = Validator::make(Input::all(),
            array(
                'transaction_fee_option' => 'required'
                )
            );

        foreach (Input::except('_token') as $key => $value) {
            $account->$key = $value;
        }

        if($account->save()){
                    return Redirect::route('account-change-settings')
                        ->with('global','Your payment settings have been changed.');
        } else {
                    return Redirect::route('account-change-settings')
                        ->with('global','System error. Your payment settings have not been changed.');
        }     

        return Redirect::route('account-change-settings')
            ->with('global','System error. Your payment settings have not been changed.');

    }

    public function getDashboard(){
        $user = Auth::user();
        $account = $this->permissionCheck('manager');

        $stats = array();
        $donation_ids = $account->donation_ids;
        $donations = $account->donations;
        $stats['Donors'] = $account->users->count();
        $stats['Donations'] = $account->donations->count();
        $stats['Online Donations'] = Donation::where('submitted_at','=','0000-00-00')->where('account_id','=',$account->id)->count();
        $stats['Giving Online'] = round((($stats['Online Donations']/$stats['Donations'])*100),2);
        $stats['All Time Donations'] = round($account->donations->sum('amount'),2);
        $stats['Average Donation'] = round(($stats['All Time Donations']/$stats['Donations']),2);
        //$stats['recurring'] =
        //$stats['last_month'] = 
        //$stats['month_to_date'] =
        //$stats['year_to_date'] =
        return View::make('account.dashboard',array('account'=>$account,'user'=>$user,'stats'=>$stats,'title'=>$account->name,'donations'=>$donations));
    }

} //end class
