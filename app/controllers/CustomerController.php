<?php

use Quezelco\Interfaces\AccountRepository as Account;
use Quezelco\Interfaces\LocationRepository as Location;
use Quezelco\Interfaces\UserRepository as User;
use Quezelco\Interfaces\UserLocationRepository as UserLocation;

class CustomerController extends \BaseController {

	public function __construct(Account $account, Location $location, User $user, UserLocation $userLocation){

		$this->user_location = $userLocation;
		$this->account = $account;
		$this->location = $location;
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$search_key = '';
		$accounts = $this->account->paginate();
		return View::make('admin.customer.index', compact('accounts', 'search_key'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$id = Session::get('user_id');
		$rules = array('account_number' => 'required|unique:accounts',
						'oebr_number' => 'required|unique:accounts',
						'meter_number' => 'required',
						'billing_address' => 'required');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('admin/add-account/' . $id)->withErrors($validator);
		}else{
			$user = $this->user->find($id);
			$this->account->addAccountToConsumer($user, Input::all());
			return Redirect::to('admin/account')->with('message','Account Successfuly Added');
		}
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//get account
		$account = $this->account->find($id);

		//get user, then get route collection
		$user = $this->user->find($account->user_id);
		$user_location = $this->user_location->findByUser($user);
		$routes = $this->location->getAllRoutes($user_location[0]->location_id);
		$arrayRoute = array();
		foreach ($routes as $route) {
			$arrayRoute[$route->id] = $route->route_name; 
		}

		return View::make('admin.customer.edit')->with('account',$account)->with('routes',$arrayRoute);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array('meter_number' => 'required',
					   'billing_address' => 'required');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('admin/account/' . $id . '/edit')->withErrors($validator);
		}else{
			$account = $this->account->find($id);
			$this->account->updateAccount($account, Input::all());
			return Redirect::to('admin/account')->with('message','Account Successfuly Updated');
		}
	}


	public function showCreateForm($id){
		Session::forget('user_id');
		Session::put('user_id',$id);
		$user = $this->user->find($id);
		$user_location = $this->user_location->findByUser($user);
		$routes = $this->location->getAllRoutes($user_location[0]->location_id);
		$arrayRoute = array();
		foreach ($routes as $route) {
			$arrayRoute[$route->id] = $route->route_name; 
		}
		return View::make('admin.customer.add')->with('routes',$arrayRoute);
	}

	public function search(){
		$search_key = Input::get('search_key');
		$accounts = $this->account->search($search_key);
		return View::make('admin.customer.index', compact('accounts', 'search_key'));
	}

	public function changeStatus($id){
		$account = $this->account->find($id);
		$this->account->changeStatus($account);
		return Redirect::to('admin/account')->with('message','Status Updated');
	}

	public function textblast(){
		$message = Input::get('message');
		$rules = array('message' => 'required');
		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::to('admin/account')->withErrors($validator);
		}else{
			$contacts = AccountContact::all();
			foreach($contacts as $contact){
				Twilio::message('+63' . $contact->contact_number, $message);
			}
		}
		Session::flash('message','Textblast Successful');
		return Redirect::to('admin/account');
	}
}
