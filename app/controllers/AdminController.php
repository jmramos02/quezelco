<?php

use Quezelco\Interfaces\UserRepository as User;
use Quezelco\Interfaces\GroupRepository as Group;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\RatesRepository as Rates;
use Quezelco\Interfaces\LogRepository as Logger;

class AdminController extends BaseController{

	public function __construct(User $user, Group $group, Auth $auth, Rates $rates, Logger $logger){
		$this->user = $user;
		$this->group = $group;
		$this->auth = $auth;
		$this->rates = $rates;
		$this->logger = $logger;
	}

	public function showIndex(){
		$logs = $this->logger->all()->paginate(10);
		return View::make('admin.index')->with('logs', $logs);
	}

	public function searchLogs()
	{
		$search_key = Input::get('search_key');
		if($search_key == ''){
			$logs = $this->logger->all()->paginate(10);
		}else{
			$logs = $this->logger->searchLogs($search_key);
		}

		return View::make('admin.index')->with('logs', $logs);
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
		return View::make('admin.monitoring');
	}

	public function showReports(){
		return View::make('admin.report');
	}

	public function showWheelingRates(){
		$rate = $this->rates->getRates();
		return View::make('admin.wheeling-rates')->with('rates',$rate);
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
}