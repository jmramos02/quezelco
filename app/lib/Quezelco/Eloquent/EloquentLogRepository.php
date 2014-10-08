<?php
namespace Quezelco\Eloquent;

use Quezelco\Interfaces\LogRepository;
use Logging;
use User;
use Quezelco\Interfaces\AuthRepository as Auth;

class EloquentLogRepository implements LogRepository{


	public function __construct(Auth $auth){
		$this->auth = $auth;
	}

	public function find($id){
		return Logging::find($id);
	}

	public function all(){
		return Logging::orderBy('created_at','desc');
	}

	public function add($id, $state){
		$log = new Logging;
		$log->user_id = $id;
		$log->status = $state;
		$log->save();
	}

	public function searchLogs($searchKey)
	{
		$query = "%$searchKey%";

		$logs = Logging::join('users', 'logs.user_id', '=', 'users.id')
					 ->join('user_location', 'users.id', '=', 'user_location.user_id')
					 ->join('locations', 'locations.id', '=', 'user_location.location_id')
					 ->whereRaw('locations.location_name LIKE ? or users.last_name LIKE ? or users.first_name LIKE ? or users.username LIKE ? and users.username != ?', 
					 	array($query,$query,$query,$query,$this->auth->getCurrentUser()->username))->paginate(10);
		return ($logs);
	}
}