<?php

use Quezelco\Interfaces\UserRepository as User;
use Quezelco\Interfaces\GroupRepository as Group;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\LocationRepository as Location;
use Quezelco\Interfaces\UserLocationRepository as UserLocationRepository;

class UserMaintenanceController extends BaseController{

	private $consumerRole = "NONE";

	public function __construct(User $user, Group $group, Auth $auth, Location $location, UserLocationRepository $userLocation){
		$this->user = $user;
		$this->group = $group;
		$this->auth = $auth;
		$this->location = $location;
		$this->userLocation = $userLocation;
	}

	public function showUserMaintenance(){
		$users = $this->user->paginate(10);
		return View::make('admin.user-maintenance')->with('users', $users);

	}

	public function showAddUser(){
		$roles = $this->group->all();
		$locations = $this->location->all();

		$arrayLocation = array();
		$arrayRole = array();
		foreach ($roles as $role) {
			if($role->name != $this->consumerRole){
				$arrayRole[$role->id] = $role->name; 
			}
		}

		foreach($locations as $location){
			$arrayLocation[$location->id] = $location->location_name;
		}
		return View::make('admin.add-user')->with('roles',$arrayRole)->with('locations',$arrayLocation);
	}

	public function saveUser(){
		$validator = $this->user->validate(Input::all());
		if($validator->fails()){
			return Redirect::to('admin/add-user')->withErrors($validator)->withInput(Input::all());
		}else{
			//saving if validation is successful
			$user = $this->auth->register(Input::all());
			$group = $this->auth->findGroupById(Input::get('role'));
			$user->addGroup($group);

			//saving to location
			$this->userLocation->addToLocation($user->id,Input::get('location'));
			//return to User-Maintenance Form
			$roles = $this->group->all();
			$arrayRole = array();
			Session::flash('message','User Created Successful');
			return Redirect::to('admin/user-maintenance');
		}
	}

	public function searchUser(){
		$search_key = Input::get('search_key');
		if($search_key == ''){
			$users = $this->user->paginate(10);
		}else{
			$users = $this->user->advanceSearch($search_key);
		}
		
		return View::make('admin.user-maintenance')->with('users', $users);
	}
	public function showEditUser($search_key){
		$roles = $this->group->all();
		$locations = $this->location->all();
		$arrayLocation = array();
		$arrayRole = array();
		foreach ($roles as $role) {
				$arrayRole[$role->id] = $role->name; 
		}

		foreach($locations as $location){
			$arrayLocation[$location->id] = $location->location_name;
		}
		$user = $this->auth->find($search_key);
		return View::make('admin.edit-user')->with('user',$user)->with('roles',$arrayRole)->with('locations',$arrayLocation);
	}
	public function modifyUser($id){
		$user = $this->user->find($id);
		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->address = Input::get('address');
		$user->contact_number = Input::get('contact_number');
		$validator = $this->user->validateEdit(Input::all());
		if($validator->fails()){
			return Redirect::to('admin/edit-user/' . $id)->withErrors($validator)->withInput(Input::all());
		}else{
			//saving if validation is successful

			$this->user->update($user);
			$this->userLocation->reset($user);
			$this->userLocation->addToLocation($user->id, Input::get('location'));
			$this->group->updateGroup($this->auth->find($user->id), Input::get('role'));
			Session::flash('message','User Modified Successful');
			return Redirect::to('admin/user-maintenance');
		}
	}
	public function activation($id){
		$user = $this->auth->find($id);
		if($user->activated == 0){
			$user->activated = 1;
		}else{
			$user->activated = 0;
		}
		$user->save();
		return Redirect::to('admin/user-maintenance');
	}

	public function showAddLocation($id){
		$user = $this->user->find($id);
		$locations = $this->location->all();
		foreach($locations as $location){
			$arrayLocation[$location->id] = $location->location_name;
		}
		return View::make('admin.user-add-location')->with('user',$user)->with('locations',$arrayLocation);
	}

	public function addLocationToUser($id){
		$location = Input::get('location');
		$this->userLocation->addToLocation($id, $location);
		return Redirect::to('admin/user-maintenance');
	}

}