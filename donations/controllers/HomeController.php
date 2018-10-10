<?php

class HomeController extends BaseController {
    public function home() {

    	if(Auth::check()){

        	$user = User::find(Auth::user()->id);

        	return View::make('home', array('user' => $user ));
    	} else {
    		return View::make('home');
    	}

    }
}
