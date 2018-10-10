<?php
	class DonorController extends BaseController {

		public function getManualAdd(){
			return View::make('account.addDonor');
		}

		public function postManualAdd(){
			$validator = Validator::make(Input::all(), 
                array(
                        'email' => 'required|max:50|email|unique:donors',
                        'phone_number' => 'required|min:10|max:11',
                        'first_name' => 'required|max:25|min:3',
                        'last_name' => 'required|max:25|min:3',                       
                        'userrole' => 'required|max:25|min:3',
                        'username' => 'required|max:25|min:3',
                        'password' => 'required|min:6',
                        'password_again' => 'required|same:password'
                )
        );

        if($validator->fails()){
            return Redirect::route('account-manual-add-donor')
                ->withErrors($validator)
                ->withInput();
        } else {
            $email = Input::get('email');
            $phone_number = Input::get('phone_number');
            $first_name = Input::get('first_name');
            $last_name = Input::get('last_name');
            $userrole = Input::get('userrole');
            $username = Input::get('username');
            $password = Input::get('password');
            $users_id = Auth::user()->id;

            $donor = Donor::create(array(
            			'users_id' => $users_id,
                        'email' => $email,
                        'phone_number' => $phone_number,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'is_manager' => $userrole,                       
                        'username' => $username,
                        'password' => Hash::make($password)
                        ));
            if($donor) {
            	/*
                Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username, 'orgname' => $orgname), function($message) use ($user) {
                       $message->to($user->email,$user->username)->subject("Activate your donors.io account.");
                   });
				*/
                return Redirect::route('account-manual-add-donor')
                    ->with('global', 'Donor account has been created.');
            } else {
            	return Redirect::route('account-manual-add-donor')
            		->withErrors($donor)
            		->withInput();
            }
        }

		}

		public function postEditDonor(){

		}

		public function postDeactivate(){

		}

	}