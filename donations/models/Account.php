<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Account extends Eloquent implements UserInterface, RemindableInterface {

    protected $fillable = array('balanced_id','name','website_url','transaction_fee_option','quarterly_statement_option','custom_message','subdomain','support_email','fund_taglist','logo_filename','city','state','address','zipcode');

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
	protected $table = 'accounts';

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

    public function permissions()
    {
        //return $this->hasMany('Permissions','account_id');
    }

    public function payouts()
    {
    	return $this->hasMany('Payouts','account_id');
    }

    public function balanced()
    {
    	return $this->hasOne('Balanced');
    }

    public function userlist()
    {
    	return $this->hasManyThrough('Permissions','User','id','user_id');
    }

    public function users()
    {
    	return $this->belongsToMany('User');
    }

    public function usersIds()
    {
    	return $this->belongsToMany('User')->select('id');
    }

    public function donations()
    {
    	return $this->hasMany('Donation','account_id');
    }

    public function donation_ids()
    {
    	return $this->hasMany('Donation','account_id')->select('id');
    }    

    public function funds()
    {
        return $this->hasMany('Fund','account_id');
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

}
