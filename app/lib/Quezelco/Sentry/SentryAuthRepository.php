<?php
namespace Quezelco\Sentry;

use Sentry;
use Input;
use Quezelco\Interfaces\AuthRepository;

class SentryAuthRepository implements AuthRepository{
	
	public function register($input){
		return Sentry::register(array(
				'username' => $input['username'],
				'address' => $input['address'],
				'password' => $input['password'],
				'activated' => '1',
				'first_name' => $input['first_name'],
				'last_name' => $input['last_name'],
				'contact_number' => $input['contact_number']
		));
	}
	
	public function findGroupById($id){
		return Sentry::findGroupById($id);
	}

	public function getCurrentUser(){
		return Sentry::getUser();
	}

	public function authenticate($credentials){
		return Sentry::authenticate($credentials,false);
	}

	public function findGroupByName($name){
		return Sentry::findGroupByName($name);
	}

	public function logout(){
		return Sentry::logout();
	}

	public function find($id){
		return Sentry::findUserById($id);
	}
	public function findUserByCredentials($inputs){
		 try{
		 	$user = Sentry::findUserByCredentials(array(
				'username' => $inputs['username'],
				'password' => $inputs['password']
			));
			return $user;
		 }catch(Cartalyst\Sentry\Users\UserNotFoundException $e){
		 	return 1;
		 }
	}
} 