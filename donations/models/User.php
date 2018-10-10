<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    protected $fillable = array('username','password','password_temp','code','first_name','last_name','phone_number','profile_icon','city','state','address','zipcode');

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
	protected $table = 'users';

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

	/* updated function set */

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

	/* custom functions */

	public function permissions()
	{
		return $this->hasOne('Permissions','user_id');
	}

    public function donations()
    {
        return $this->hasMany('Donation','user_id');
    }

    public function balanced()
    {
    	return $this->hasMany('Balanced');
    }

    public function recurring()
    {
    	return $this->hasMany('Recurring','user_id');
    }

    public function account()
    {
    	return $this->belongsToMany('Account');
    }

}
