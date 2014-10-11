<?php
use Quezelco\Interfaces\BillRepository as Billing;
use Quezelco\Interfaces\AccountRepository as AccountRepo;
use Quezelco\Interfaces\RatesRepository as Rates;
use Carbon\Carbon;

class CadController extends BaseController {

	public function __construct(Billing $bill,AccountRepo $account, Rates $rates){
		$this->account = $account;
		$this->bill = $bill;
		$this->rates = $rates;
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
}