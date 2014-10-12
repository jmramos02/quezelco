<?php
use Quezelco\Interfaces\BillRepository as Billing;
use Quezelco\Interfaces\AccountRepository as AccountRepo;
use Quezelco\Interfaces\RatesRepository as Rates;
use Quezelco\Interfaces\AuthRepository as Auth;

use Carbon\Carbon;

class CadController extends BaseController {

	public function __construct(Billing $bill,AccountRepo $account, Rates $rates, Auth $auth){
		$this->account = $account;
		$this->bill = $bill;
		$this->rates = $rates;
		$this->auth = $auth;
	}
	public function showHome()
	{
		$search_key = '';
		$bills = $this->bill->search($search_key);
		return View::make('cad.billing', compact('bills', 'search_key'));
	}

	public function search()
	{
		$search_key = Input::get('searchKey');
        $bills = $this->bill->search($search_key);

        return View::make('cad.billing', compact('bills', 'search_key'));
	}

	public function showReports() {
		return View::make('cad.report');
	}

	public function showMonitoring() {
		return View::make('cad.monitoring');
	}

	public function showMyAccount(){
		return View::make('cad.my-account');
	}

	public function updatePassword()
	{
		$rules = array('current_password' =>'required',
				'new_password' => 'required',
				'repeat_new_password' => "same:new_password");

		$validator = Validator::make(Input::all(), $rules);
		if( $validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user = $this->auth->getCurrentUser();

		if (!Hash::check(Input::get('current_password'), $user->password))
		{
		    return Redirect::back();
		}

		$user->password = Input::get('new_password');
		$user->save();

		return Redirect::to('cad/home');
	}
}