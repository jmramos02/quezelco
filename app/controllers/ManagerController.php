<?php

use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\UserRepository as User;
use Quezelco\Interfaces\AccountRepository as Account;

class ManagerController extends BaseController{
	
	public function __construct(Auth $auth, User $user, Account $account){
		$this->auth = $auth;
		$this->account = $account;
		$this->user = $user;
	}
	public function showIndex(){
		//get user to get the id of the damn user
		$user = $this->auth->getCurrentUser();
		//get damn location out of the user
		$locations = $this->user->find($user->id)->locations()->get();
		//get all consumer accounts
		$id = $this->auth->findGroupByName('Consumer')->id;
		//arraying~
		$location_id = array();
		foreach($locations as $location){
			$location_id[] = $location->id;
		}
		$search_key = '';
		$users = $this->user->getManagerViewPaginated($id, $location_id);
		return View::make('manager.index', compact('users','search_key'));
	}

	public function changeStatus($id){
		$account = $this->account->find($id);
		$this->account->changeStatus($account);
		Session::flash('message','Status Updated');
		return Redirect::to('manager/home');
	}

	public function search(){
		//get user to get the id of the damn user
		$user = $this->auth->getCurrentUser();
		//get damn location out of the user
		$locations = $this->user->find($user->id)->locations()->get();
		//get all consumer accounts
		$id = $this->auth->findGroupByName('Consumer')->id;
		//arraying~
		$location_id = array();
		foreach($locations as $location){
			$location_id[] = $location->id;
		}
		$search_key = Input::get('search_key');
		$users = $this->user->searchManagerView($id, $location_id, $search_key);
		return View::make('manager.index', compact('users', 'search_key'));
	}
}