<?php
namespace Quezelco\Eloquent;

use User;
use Validator;
use Group;
use UserLocation;
use Quezelco\Interfaces\UserRepository;
use Quezelco\Interfaces\AuthRepository as Auth;

class EloquentUserRepository implements UserRepository{

	public function __construct(Auth $auth){
		$this->auth = $auth;
	}

	public function all(){
		return User::all();
	}

	public function find($id){
		return User::find($id);
	}

	public function findByUsername($username){
		return User::where('username','=',$username);
	}

	public function paginate($pages){
		return User::with('locations')->where('username','!=',$this->auth->getCurrentUser()->username)->paginate($pages);
	}

	public function validate($inputs){
		$rules = array(
			'username' => 'required|min:5|unique:users',
			'password' => 'required|confirmed|min:5',
			'address' => 'required',
			'first_name' => 'required',
			'last_name' => 'required'
		);

		return Validator::make($inputs,$rules);
	}

	public function validateEdit($inputs){
		$rules = array(
			'address' => 'required',
			'first_name' => 'required',
			'last_name' => 'required'
		);
		return Validator::make($inputs,$rules);
	}
	public function advanceSearch($searchKey){
		$query = "%$searchKey%";

		/*$users = User::join('user_location', 'users.id', '=', 'user_location.user_id')
					 ->join('locations', 'user_location.location_id', '=', 'locations.id')
					 ->whereRaw('(locations.location_name LIKE ? or users.last_name LIKE ? or users.first_name LIKE ? or username LIKE ?) and username != ?', 
					 	array($query,$query,$query,$query,$this->auth->getCurrentUser()->username))->paginate(10);*/

		$users = User::with('locations')->whereRaw('(username LIKE ? or first_name LIKE ? or last_name LIKE ?) and username != ?',
				 array($query,$query,$query,$this->auth->getCurrentUser()->username))->paginate(10);
		return ($users);
	}
	
	public function update($user){
		return $user->save();
	}

	public function getAllCustomers(){
		return Group::customers();
	}

	public function findCustomer($id){
		return Group::findCustomer($id);
	}
}