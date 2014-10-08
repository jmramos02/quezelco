<?php

namespace Quezelco\Eloquent;

use Quezelco\Interfaces\AuditTrailsRepository;
use AccountsContact;
use User;

class EloquentAuditTrailsRepository implements AccountsContactRepository {

	private $recordsPerPage = 15;

	public function all(){
		return AccountsContact::all();
	}

	public function find($id){
		return AccountsContact::find($id);
	}

}