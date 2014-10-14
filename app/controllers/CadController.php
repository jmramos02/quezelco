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

	public function consumerList(){
		Fpdf::AddPage();
		Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Consumer List as of ' . Carbon::now(),0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(38, 10, "Account Number" , 1, 0, 'L', true);
        Fpdf::Cell(38, 10, "OEBR Number", 1, 0, 'L', true);
        Fpdf::Cell(38, 10, "Last Name" , 1, 0, 'L', true);
        Fpdf::Cell(38, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Cell(38, 10, "Branch" , 1, 0, 'L', true);
        Fpdf::Ln();

         $accounts = $this->account->all();

        Fpdf::SetFillColor(255);
        Fpdf::SetTextColor(0);
                
        foreach($accounts as $account){
        	Fpdf::Cell(38, 6, $account->account_number, 1, 0, 'L', true);
          	Fpdf::Cell(38, 6, $account->oebr_number, 1, 0, 'L', true);
        	Fpdf::Cell(38, 6, $account->consumer()->first()->last_name, 1, 0, 'L', true);
        	Fpdf::Cell(38, 6, $account->consumer()->first()->first_name, 1, 0, 'L', true);
        	Fpdf::Cell(38, 6, $account->routes()->first()->route_name, 1, 0, 'L', true);
        	Fpdf::Ln();
        }

        Fpdf::Output();
        exit;
	}

	public function smsList(){
		Fpdf::AddPage();
		Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Sms List as of ' . Carbon::now(),0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(45, 10, "Account Number" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "Contact Number", 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "Last Name" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Ln();

         $contacts = AccountContact::all();

        Fpdf::SetFillColor(255);
        Fpdf::SetTextColor(0);
                
        foreach($contacts as $contact){
        	Fpdf::Cell(45, 6, $contact->consumer()->first()->account_number, 1, 0, 'L', true);
          	Fpdf::Cell(45, 6, $contact->contact_number, 1, 0, 'L', true);
        	Fpdf::Cell(45, 6, $contact->consumer()->first()->consumer()->first()->last_name, 1, 0, 'L', true);
        	Fpdf::Cell(45, 6, $contact->consumer()->first()->consumer()->first()->first_name, 1, 0, 'L', true);
        	Fpdf::Ln();
        }

        Fpdf::Output();
        exit;

	}
}