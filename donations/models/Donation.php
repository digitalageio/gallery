<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Donation extends Eloquent implements UserInterface, RemindableInterface {

    protected $fillable = array('date','user_id','account_id','submitted_at','submitted_by','fund','source','type','amount','status','approved','optional');

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
	protected $table = 'donations';

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

	public function user()
	{
		return $this->belongsTo('User','user_id');
	}

	public function editable(){
		if($this->submitted_at != "0000-00-00"){
			return true;
		} else return false;
	}

	public function listByAccount()
	{
		return $this->belongsTo('Account','account_id');
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
