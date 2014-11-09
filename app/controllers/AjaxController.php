<?php
use Carbon\Carbon;
use Quezelco\Interfaces\AuthRepository as Auth;

class AjaxController extends BaseController{

	public function __construct(Auth $auth){
		$this->auth = $auth;
	}

	public function paymentsAnnual($year){
		$haha = array();
		for($index = 1; $index <= 12; ++$index){
			$dt = Carbon::create($year, $index, 31, 12, 0, 0);
			$haha[$index - 1] = Payment::where(DB::raw('MONTH(created_at)'), '=', $index)->count();
		}

		return Response::json($haha);
	}

	public function paymentsAnnualManager($year)
	{
		$return = array();

		$user = $this->auth->getCurrentUser();
        $groupId = UserGroups::where('user_id', '=', $user->id)->first();

        if($groupId->group_id == 3)
        {
            for($index = 1; $index <= 12; ++$index)
            {
				$dt = Carbon::create($year, $index, 31, 12, 0, 0);
				$return[$index - 1] = User::join('user_location', 'users.id', '=', 'user_location.user_id')
			            				->join('locations', 'user_location.location_id', '=', 'locations.id')
			            				->join('routes', 'locations.id', '=', 'routes.location_id')
			            				->join('accounts', 'routes.id', '=', 'accounts.route_id')
			            				->join('bills', 'accounts.id', '=', 'bills.account_id')
			            				->join('payment', 'bills.id', '=', 'payment.bill_id')
			            				->whereRaw('users.id = ? AND MONTH(payment.created_at) = ?', 
			            					array($user->id, $index))
			            				->count();

			}

			return Response::json($return);
        }
	}

	public function customerStatus(){
		$return = array();
		$location_id = Input::get('location');
		if($location_id != 0){
			$connected = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->where('user_location.location_id','=',$location_id)
            				 ->where('accounts.status', '=','1')
            				 ->count();
			$disconnected = User::join('user_location', 'users.id', '=', 'user_location.user_id')
	            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
	            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
	            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
	            				 ->where('user_location.location_id','=',$location_id)
	            				 ->where('accounts.status', '=','0')
	            				 ->count();
		}else{
			$connected = Account::where('status','=','1')->count();
			$disconnected = Account::where('status','=','0')->count();
		}
		
		$return[0] = $connected;
		$return[1] = $disconnected;
		return Response::json($return);
	}

	public function customerStatusManager()
	{
		$return = array();

		$user = $this->auth->getCurrentUser();
        $groupId = UserGroups::where('user_id', '=', $user->id)->first();

        if($groupId->group_id == 3)
        {
            $connected = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->whereRaw('users.id = ? AND status = ?', array($user->id, 1))
            				 ->count();

			$disconnected = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->whereRaw('users.id = ? AND status = ?', array($user->id, 0))
            				 ->count();


			$return[0] = $connected;
			$return[1] = $disconnected;

			return Response::json($return);
        }
	}

	public function billingStatus(){
		$return = array();
		$location_id = Input::get('location');
		if($location_id == 0){
			$disconnection = Bill::where('payment_status' , '=' , 3)->count();
			$penalties = Bill::where('payment_status' ,'=' , 2)->count();
			$paid = Bill::where('payment_status' , '=' , 0)->count();
			$notYetPaid = Bill::where('payment_status', '=' , 1)->count();
		}else{
		$disconnection = Bill::join('accounts', 'bill.account_id', '=', 'accounts.id')
							 ->join('users','accounts.user_id','accounts.id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->where('user_location.location_id','=',$location_id)
            				 ->where('bill.payment_status', '=','3')
            				 ->count();
		$penalties = Bill::join('accounts', 'bill.account_id', '=', 'accounts.id')
							 ->join('users','accounts.user_id','accounts.id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->where('user_location.location_id','=',$location_id)
            				 ->where('bill.payment_status', '=','2')
            				 ->count();
		$paid = Bill::join('accounts', 'bill.account_id', '=', 'accounts.id')
							 ->join('users','accounts.user_id','accounts.id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->where('user_location.location_id','=',$location_id)
            				 ->where('bill.payment_status', '=','0')
            				 ->count();
		$notYetPaid = Bill::join('accounts', 'bill.account_id', '=', 'accounts.id')
							 ->join('users','accounts.user_id','accounts.id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->where('user_location.location_id','=',$location_id)
            				 ->where('bill.payment_status', '=','1')
            				 ->count();
		}
		$return[0] = $paid;
		$return[1] = $notYetPaid;
		$return[2] = $penalties;
		$return[3] = $disconnection;
		return Response::json($return);
	}

	public function billingStatusManager()
	{
		$return = array();

		$user = $this->auth->getCurrentUser();
        $groupId = UserGroups::where('user_id', '=', $user->id)->first();

        if($groupId->group_id == 3)
        {
            $disconnection = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->join('bills', 'accounts.id', '=', 'bills.account_id')
            				 ->whereRaw('users.id = ? AND payment_status = ?', array($user->id, 3))
            				 ->count();

			$penalties = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->join('bills', 'accounts.id', '=', 'bills.account_id')
            				 ->whereRaw('users.id = ? AND payment_status = ?', array($user->id, 2))
            				 ->count();

            $paid = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->join('bills', 'accounts.id', '=', 'bills.account_id')
            				 ->whereRaw('users.id = ? AND payment_status = ?', array($user->id, 0))
            				 ->count();

            $notYetPaid = User::join('user_location', 'users.id', '=', 'user_location.user_id')
            				 ->join('locations', 'user_location.location_id', '=', 'locations.id')
            				 ->join('routes', 'locations.id', '=', 'routes.location_id')
            				 ->join('accounts', 'routes.id', '=', 'accounts.route_id')
            				 ->join('bills', 'accounts.id', '=', 'bills.account_id')
            				 ->whereRaw('users.id = ? AND payment_status = ?', array($user->id, 1))
            				 ->count();

			$return[0] = $paid;
			$return[1] = $notYetPaid;
			$return[2] = $penalties;
			$return[3] = $disconnection;
			return Response::json($return);
        }
	}

	public function paymentHistory(){
		$disconnection = Bill::where('payment_status' , '=' , 3)->count();
		$penalties = Bill::where('payment_status' ,'=' , 2)->count();
		$paid = Bill::where('payment_status' , '=' , 0)->count();
		$notYetPaid = Bill::where('payment_status', '=' , 1)->count();
	}
}