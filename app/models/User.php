<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

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
	protected $hidden = array('password', 'remember_token');

	/*Many to Many Relationship*/

	public function locations(){
		return $this->belongsToMany('Location','user_location');
	}

	public function route(){
		return $this->hasOne('QRoute','routes');
	}

	public function consumer(){
		return $this->hasMany('Account','user_id');
	}
}