<?php

use Quezelco\Interfaces\UserRepository as User;
use Quezelco\Interfaces\GroupRepository as Group;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\RatesRepository as Rates;
use Quezelco\Interfaces\LogRepository as Logger;
use Quezelco\Interfaces\LocationRepository as Location;

class AdminController extends BaseController{

	public function __construct(User $user, Group $group, Auth $auth, Rates $rates, Logger $logger, Location $location){
		$this->user = $user;
		$this->group = $group;
		$this->auth = $auth;
		$this->rates = $rates;
		$this->logger = $logger;
		$this->location = $location;
	}

	public function showIndex(){
		$logs = $this->logger->all()->paginate(10);
		$search_key = "";
		return View::make('admin.index')->with('logs', $logs)->with('search_key',$search_key);
	}

	public function searchLogs()
	{
		$search_key = Input::get('search_key');
		if($search_key == ''){
			$logs = $this->logger->all()->paginate(10);
		}else{
			$logs = $this->logger->searchLogs($search_key);
		}

		return View::make('admin.index')->with('logs', $logs)->with('search_key',$search_key);
	}

	public function showCashier(){
		return View::make('admin.cashier');
	}

	public function showAddCustomer(){
		return View::make('admin.add-customer');
	}

	public function showDisconnectedBills(){
		return View::make('admin.disconnected-bills');
	}

	public function showMonitoring(){
		$locations = $this->location->all();
		$arrayLocation = array();
		$arrayLocation[0] = 'All';
		foreach($locations as $location){
			$arrayLocation[$location->id] = $location->location_name;
		}
		return View::make('admin.monitoring')->with('locations',$arrayLocation);
	}

	public function showReports(){
		return View::make('admin.report');
	}

	public function showWheelingRates(){
		$rate = $this->rates->getRates();
		$history = RatesHistory::all();
		$rates_history = array();
		foreach($history as $h){
			$rates_history[$h->id] = $h->before_date;
		}
		return View::make('admin.wheeling-rates')->with('rates',$rate)->with('rates_history',$rates_history);
	}

	/*Wheeling Rates*/

	public function saveWheelingRates(){
		$validator = $this->rates->validate(Input::all());
		if($validator->fails()){
			return Redirect::to('admin/wheeling-rates')->withErrors($validator)->withInput(Input::all());
		}else{
			//tryy
			try{
				$user = $this->auth->findUserByCredentials(Input::all());
			}catch(Cartalyst \ Sentry \ Users \ UserNotFoundException $e){
				Session::flash('error_message','No user found');
				return Redirect::to('admin/wheeling-rates');
			}
		
			if($user->inGroup($this->auth->findGroupByName('Consumers Area Department'))){
				$this->rates->update(Input::all());
			}else{
				Session::flash('error_message','Only CAD roles are allowed to change rates');
				return Redirect::to('admin/wheeling-rates');
			}
		}
		Session::flash('message','Wheeling Rates Updated');
		return Redirect::to('admin/wheeling-rates');
	}

	public function showOtherReports(){
		$tables = array('users' => 'users',
                        'accounts' => 'accounts',
                        'accounts_contact' => 'accounts_contact',
                        'audit_trails' => 'audit_trails',
                        'bills' => 'bills',
                        'groups' => 'groups',
                        'locations' => 'location',
                        'logs' => 'logs',
                        'migrations' => 'migrations',
                        'payment' => 'payment',
                        'routes' => 'routes',
                        'throttle' => 'throttle',
                        'users_groups' => 'users_groups',
                        'user_location' => 'user_location',
                        'wheeling_rates' => 'wheeling_rates',
                        'rates_history' => 'rates_history');
		$locations = $this->location->all();
		$arrayLocation = array();
		foreach($locations as $location){
			$arrayLocation[$location->id] = $location->location_name;
		}
		return View::make('admin.other-reports')->with('locations', $arrayLocation)->with('tables', $tables);
	}
}