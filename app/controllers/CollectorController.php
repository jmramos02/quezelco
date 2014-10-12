<?php
use Quezelco\Interfaces\BillRepository as Bill;

class CollectorController extends BaseController{
	public function __construct(Bill $bill){
		$this->bill = $bill;
	}
	public function showHome(){
		return View::make('collector.index');
	}

	public function showOEBR(){
		$rules = array('oebr' => 'required|exists:accounts,oebr_number');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('collector/home')->withErrors($validator);
		}else{
			$oebr = Input::get('oebr');
			$bill = $this->bill->findNextPayment($oebr);
			if(is_null($bill)){
				Session::flash('message','There are no pending dues for this account');
				return Redirect::to('collector/home');
			}
			return View::make('collector.payment')->with('bill',$bill);
		}
		
	}

	public function acceptPayment($id){
		$bill = $this->bill->find($id);

		$bill->payment_status = 1;
		$bill->save();
		$payment = new Payment();
		$payment->payment = Input::get('payment');
		$payment->change = Input::get('payment') - $bill->due_payment;
		$payment->bill_id = $id;

		$payment->save();
		Session::flash('message','Payment Accepted! Change is: ' . $payment->change);
		return Redirect::to('collector/home');
	}

	public function showMyAccount(){
		return View::make('collector.my-account');
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

		print_r($user->password . '<br/><br/>');

		if (!Hash::check(Input::get('current_password'), $user->password))
		{
		    return Redirect::back();
		}

		$user->password = Input::get('new_password');
		$user->save();

		return Redirect::to('collector/home');
	}
}