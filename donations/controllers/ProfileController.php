<?php
class ProfileController extends BaseController {
    public function user($username){

        $user = User::where('username', '=', $username);

        if($user->count()){
            $user = $user->first();
            return View::make('profile.user')
                ->with('user',$user);
        } 

        return App::abort(404);
    }

    public function donation($id){

        $donation = Donation::find($id);

        if($donation){

            return View::make('profile.donation')
                ->with('donation',$donation);
        }

        return App::abort(404);
    }

    public function account($subdomain){

        $subdomain = Session::get('subdomain');
        $account = Account::where('subdomain','=',$subdomain);

        if($account->count()){
            $account = $account->first();
            return View::make('profile.dashboard')
                ->with('account',$account);
        }

        return App::abort(404);
    }

}

