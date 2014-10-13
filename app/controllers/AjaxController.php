<?php
use Carbon\Carbon;

class AjaxController extends BaseController{

	public function paymentsAnnual($year){
		$haha = array();
		for($index = 1; $index <= 12; ++$index){
			$dt = Carbon::create($year, $index, 31, 12, 0, 0);
			$haha[$index - 1] = Payment::where(DB::raw('MONTH(created_at)'), '=', $index)->count();
		}

		return Response::json($haha);
	}

	public function customerStatus(){
		$return = array();
		$connected = Account::where('status', '=', '1')->count();
		$disconnected = Account::where('status', '=' ,'0')->count();
		$return[0] = $connected;
		$return[1] = $disconnected;
		return Response::json($return);
	}

	public function billingStatus(){
		$return = array();
		$disconnection = Bill::where('payment_status' , '=' , 3)->count();
		$penalties = Bill::where('payment_status' ,'=' , 2)->count();
		$paid = Bill::where('payment_status' , '=' , 0)->count();
		$notYetPaid = Bill::where('payment_status', '=' , 1)->count();
		$return[0] = $paid;
		$return[1] = $notYetPaid;
		$return[2] = $penalties;
		$return[3] = $disconnection;
		return Response::json($return);
	}

	public function logsStatus(){

	}

	public function paymentHistory(){
		$disconnection = Bill::where('payment_status' , '=' , 3)->count();
		$penalties = Bill::where('payment_status' ,'=' , 2)->count();
		$paid = Bill::where('payment_status' , '=' , 0)->count();
		$notYetPaid = Bill::where('payment_status', '=' , 1)->count();
	}
}