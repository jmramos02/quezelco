<?php

class AccountContact extends Eloquent{
	protected $table = 'accounts_contact';
	public $timestamps = false;

	public function account(){
		return $this->belongsTo('Account','account_id');
	}
}