<?php
	class DonationController extends BaseController {

        public function permissionCheck($level){

            $user = User::find(Auth::user()->id)->first();
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

		public function postManualAdd(){

            $account = $this->permissionCheck('manager');

			$validator = Validator::make(Input::all(), 
                array(
                        'amount' => 'numeric|required',
                        'month' => 'numeric|required|min:1|max:12',
                        'day' => 'numeric|required|max:31|min:1',
                        'year' => 'numeric|required',                       
                        'type' => 'required'
                )
        );

        if($validator->fails()){
            return Redirect::route('donation-list-donations')
                ->withErrors($validator)
                ->withInput();
        } else {
            $amount = Input::get('amount');
            $month = Input::get('month');
            $day = Input::get('day');
            $year = Input::get('year');
            $date = date('Y-m-d',strtotime($year . '-' . $month . '-' . $day));
            $type = Input::get('type');
            $optional = Input::get('optional');
            $fund = Input::get('fund');
            $source = Input::get('source');
            $user_id = Input::get('asUser');
            $submitted_by = Auth::user()->id;

            $donation = Donation::create(array(
            			'amount' => $amount,
                        'submitted_at' => $date,
                        'submitted_by' => $submitted_by,
                        'date' => $date,
                        'type' => $type,
                        'optional' => $optional,
                        'fund' => $fund,
                        'source' => $source,                       
                        'user_id' => $user_id,
                        'account_id' => $account->id
                        ));
            if($donation) {
                if($user_id == 7){
            	/*
                Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username, 'orgname' => $orgname), function($message) use ($user) {
                       $message->to($user->email,$user->username)->subject("Activate your donors.io account.");
                   });
				*/
                return Redirect::route('donation-list-donations')
                    ->with('global', 'Donation added.');
                } else {
                    $username = User::where('username','=',$username)->select('username')->first();
                    return Redirect::route('/user/profile/' . $username);
                }
            } else {
            	return Redirect::route('donation-list-donations')
            		->withErrors($donor)
            		->withInput();
            }
        }

		}

        public function getDonationList(){
            $user = Auth::user();
            $account = $this->permissionCheck('donor');
            $donations = Donation::where('account_id','=',$account->id)->get();
            //if($donations){
                return View::make('donation.list',array('account' => $account,'donations' => $donations,'user' => $user));
            //} else return View::make('donation.list',array('account' => $account));
            //return View::make('donation.list');
        }
/*
		public function postDeleteDonation(){

		}

        public function postAddDonation(){

        }

		public function postSetRecurring(){

		}
*/
        public function postFormAdd(){
            $validator = Validator::make(Input::all(), 
                array(
                        'amount' => 'numeric|required|match:/^[0-9]{1,4}\.[0-9]{2}$/',
                        'month' => 'numeric|required|min:1|max:12',
                        'day' => 'numeric|required|max:31|min:1',
                        'year' => 'numeric|required',                       
                        'type' => 'required',
                        'optional' => '',
                        'fund' => 'required',
                        'source' => 'required'
                )
        );

        if($validator->fails()){
            return Redirect::route('donor-profile')
                ->withErrors($validator)
                ->withInput();
        } else {
            $amount = Input::get('amount');
            $month = Input::get('month');
            $day = Input::get('day');
            $year = Input::get('year');
            $type = Input::get('type');
            $optional = Input::get('optional');
            $fund = Input::get('fund');
            $source = Input::get('source');
            $user_id = User::find(Auth::user()->id)->first()->id;
            $account_id = $account->id;

            $donor = Donation::create(array(
                        'amount' => $amount,
                        'approved_date' => $approved_date,
                        'type' => $type,
                        'optional' => $optional,
                        'fund' => $fund,
                        'source' => $source,                       
                        'user_id' => $users_id,
                        'account_id' => $account->id
                        ));
            if($donor) {
                /*
                Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username, 'orgname' => $orgname), function($message) use ($user) {
                       $message->to($user->email,$user->username)->subject("Activate your donors.io account.");
                   });
                */
                return Redirect::route('donor-profile')
                    ->with('global', 'Donor account has been created.');
            } else {
                return Redirect::route('donor-profile')
                    ->withErrors($donor)
                    ->withInput();
            }
        }

        }       

	}