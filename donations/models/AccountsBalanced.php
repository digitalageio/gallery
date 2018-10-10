<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class AccountsBalanced extends Eloquent implements UserInterface, RemindableInterface {

    protected $fillable = array('account_id','uri','type');

    /**
     * Set softDelete property
     *
     * @var bool
     */
    protected $softDelete = true;

    protected $primaryKey = 'id';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'accounts_balanced';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	public function account()
	{
		return $this->belongsTo('Account');
	}

	public function user()
	{
		return $this->belongsTo('User');
	}

	public function getRememberToken()
	{
	    return $this->remember_token;
	}

	public function setRememberToken($value)
	{
	    $this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
	    return 'remember_token';
	}



    public static function fetchBalanced($uri){

        $url = 'https://api.balancedpayments.com' . $uri;
    	$options = array( 
                CURLOPT_HEADER         	=> false,        
                CURLOPT_ENCODING       	=> "",           
                CURLOPT_AUTOREFERER    	=> true, 
                CURLOPT_POST            => 0, 
                CURLOPT_SSL_VERIFYHOST 	=> 0, 
                CURLOPT_SSL_VERIFYPEER 	=> false,
                CURLOPT_RETURNTRANSFER 	=> 1,
                CURLOPT_USERPWD        	=> 'fake-test-1MPYYtNxEwHED4zWWAIEw65597pc8eJZJpfp:',
                CURLOPT_HTTPHEADER 		=>  array('Accept: application/vnd.api+json;revision=1.1'),
                CURLOPT_HTTPAUTH 		=> CURLAUTH_BASIC
    	); 

        $ch = curl_init($url);

        curl_setopt_array($ch,$options);
        $output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($output,true);

        if(!empty($response)){
            return $response;
        } else return false;
    }

    public static function cURLBalanced($url,$post){

    	$options = array( 
                CURLOPT_HEADER         	=> false,        
                CURLOPT_ENCODING       	=> "",           
                CURLOPT_AUTOREFERER    	=> true, 
                CURLOPT_POST            => 1, 
                CURLOPT_SSL_VERIFYHOST 	=> 0,
                CURLOPT_SSL_VERIFYPEER 	=> false,
                CURLOPT_POSTFIELDS		=> '',
                CURLOPT_RETURNTRANSFER 	=> 1,
                CURLOPT_USERPWD        	=> 'fake-test-1MPYYtNfxEwHEDzWWAIhEw6559pceJZJpfp:',
                CURLOPT_HTTPHEADER 		=> array('Accept: application/vnd.api+json;revision=1.1'),
                CURLOPT_HTTPAUTH 		=> CURLAUTH_BASIC
    	);

    	if(!empty($post)){
    		$data = http_build_query($post);
    		$options[CURLOPT_POSTFIELDS] = $data;
    	}

        $ch = curl_init($url);

        curl_setopt_array($ch,$options);

        $output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($output,true);

        if(!empty($response)){
            return $response;
        } else return false;
    }

    public static function createBankAccount(){

    }

    public static function createVerification($uri){
    	$base = 'https://api.balancedpayments.com';
    	$url = $base . $uri . '/verifications';
    	return $url;
    }

    public static function attemptVerification($uri,$post){
    	$url = 'https://api.balancedpayments.com' . $uri;
    	$options = array( 
                CURLOPT_HEADER         	=> false,        
                CURLOPT_ENCODING       	=> "",           
                CURLOPT_AUTOREFERER    	=> true, 
                CURLOPT_CUSTOMREQUEST   => "PUT", 
                CURLOPT_SSL_VERIFYHOST 	=> 0,
                CURLOPT_SSL_VERIFYPEER 	=> false,
                CURLOPT_POSTFIELDS		=> '',
                CURLOPT_RETURNTRANSFER 	=> 1,
                CURLOPT_USERPWD        	=> 'fake-test-1MPYYtyNxEwHEDz3rWWAIEwg6559pceJZJpfp:',
                CURLOPT_HTTPHEADER 		=> array('Accept: application/vnd.api+json;revision=1.1'),
                CURLOPT_HTTPAUTH 		=> CURLAUTH_BASIC
    	);

    	if(!empty($post)){
    		$data = http_build_query($post);
    		$options[CURLOPT_POSTFIELDS] = $data;
    	}

        $ch = curl_init($url);

        curl_setopt_array($ch,$options);

        $output = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($output,true);

        if(!empty($response)){
            return $response;
        } else return false;
    }

    public static function createCredit(){

    }

    public static function associateToCustomer(){

    }

}
