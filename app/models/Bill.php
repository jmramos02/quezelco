<?php

class Bill extends Eloquent{
	protected $table = "bills";

	public function account(){
		return $this->belongsTo('Account');
	}

	public function payment(){
		return $this->hasOne('Payment');
	}
}