<?php
use Quezelco\Interfaces\AccountRepository as Account;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\BillRepository as Bill;
class ConsumerController extends BaseController{

	public function __construct(Account $account, Auth $auth, Bill $bill){
		$this->account = $account;
		$this->auth = $auth;
		$this->bill = $bill;
	}

	public function showHome(){
		$user = $this->auth->getCurrentUser();
		$accounts = $this->account->findAccountsByUser($user)->paginate(5);
		return View::make('consumer.index')->with('user', $user)->with('accounts',$accounts);
	}

	public function showEnroll($id){
		$user = $this->auth->getCurrentUser();
		return View::make('consumer.enroll')->with('user', $user)->with('id', $id);
	}

	public function enroll($id){
		$contact = new AccountContact();
		$rules = array('number' => 'required|size:10');
		$validator = Validator::make(Input::all(),$rules);
		if($validator->fails()){
			return Redirect::to('consumer/enroll/' . $id)->withErrors($validator);
		}else{
			$contact->account_id = $id;
			$contact->contact_number = Input::get('number');
			$contact->save();
			$account = $this->account->find($id);
			Twilio::message('+63' . Input::get('number'),'Your number has been successfuly enrolled! -Quezelco Management Account Number: ' . $account->account_number);
		}
		Session::flash('message','You will received a message shortly regarding on the confirmation of your sms enrollment');
		return Redirect::to('consumer/home');
	}

	public function showMyAccount(){
		return View::make('consumer.my-account');
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

		return Redirect::to('consumer/home');
	}

	public function showBillingHistory(){
		$user = $this->auth->getCurrentUser();
		$account = $this->account->findAccountsByUser($user)->first();
		$bills = $this->bill->findByAccount($account);
		return View::make('consumer.billing-history')->with('bills', $bills);
	}
}