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

	public function paymentsMonthly($month){

	}
}