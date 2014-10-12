<?php

class AccountContact extends Eloquent{
	protected $table = 'accounts_contact';
	public $timestamps = false;

	public function consumer(){
		return $this->belongsTo('Account');
	}
}