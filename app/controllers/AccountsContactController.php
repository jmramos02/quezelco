<?php

use Quezelco\Interfaces\AccountsContactRepository as AccountsContact;

class AccountsContactController extends BaseController {

	public function __construct(AccountsContact $accounts_contact){
		$this->accounts_contact = $accounts_contact;
	}

	public function all(){
		return $this->accounts_contact->all();
	}

	public function find($id) {
		return $this->accounts_contact->find($id);
	}
	
}