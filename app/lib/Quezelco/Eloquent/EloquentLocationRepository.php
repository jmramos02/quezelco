<?php
 namespace Quezelco\Eloquent;
 use Location;
 use QRoute;
 use Quezelco\Interfaces\LocationRepository;
 
 class EloquentLocationRepository implements LocationRepository{

 	private $recordsPerPage = 10;
 	
 	public function find($id){
 		return Location::find($id);
 	}

 	public function all(){
 		return Location::all();
 	}

 	public function add($inputs){
 		$location = new Location();
 		$location->district = strtoupper($inputs['district_name']);
 		$location->location_name = strtoupper($inputs['location_name']);
 		$location->save();
 	}

 	public function update($location){
 		$location->save();
 	}

 	public function delete($location){
 		$location->delete();
 	}

 	public function getRoutes($location){
 		return $location->routes()->paginate($this->recordsPerPage);
 	}

 	public function search($searchKey){
 		return Location::where('location_name','like',"%$searchKey%")->paginate(10);
 	}

 	public function paginate($location){
 		return $location->paginate($this->recordsPerPage);
 	}

 	public function getAllPaginated(){
 		return Location::paginate($this->recordsPerPage);
 	}

 	public function getAllRoutes($location_id){
 		return QRoute::where('location_id','=',$location_id)->get();
 	}

 	public function findDisconnectedConnectedAccounts($locationid, $status)
 	{
 		$connect = Location::join('user_location', 'locations.id', '=', 'user_location.location_id')
 								->join('users', 'user_location.user_id', '=', 'users.id')
 								->join('accounts','users.id','=','accounts.user_id')
 								->where('accounts.status', '=', $status)
 								->where('user_location.location_id', '=', $locationid)
 								->select('users.first_name as firstname', 'users.last_name as lastname',
 										'accounts.oebr_number as oebrnumber', 'locations.location_name as routename')
 								->get();
 		return $connect;
 	}

 }