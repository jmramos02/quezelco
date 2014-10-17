<?php
use Carbon\Carbon;
use Quezelco\Interfaces\AccountRepository as Account;
use Quezelco\Eloquent\EloquentUserRepository as User;
use Quezelco\Eloquent\EloquentLocationRepository as Location;
use Quezelco\Eloquent\EloquentRoutesRepository as QRoutes;
use Quezelco\Eloquent\EloquentBillRepository as Bill;

class ReportController extends BaseController{

	public function __construct(User $user, Location $location, Qroutes $route, Account $account, Bill $bill){
		$this->location = $location;
		$this->user = $user;
		$this->route = $route;
		$this->account = $account;
                $this->bill = $bill;
	}

	public function generateUserList(){
		Fpdf::AddPage();
		Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'User List as of ' . Carbon::now(),0,1,'C');
        Fpdf::SetFont('Courier','','9');

		Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(32, 10, "ID" , 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "Username" , 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "Last Name" , 1, 0, 'L', true);
        Fpdf::Cell(32 ,10, 'Contact Number', 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "Role" , 1, 0, 'L', true);
        Fpdf::Ln();

        $users = $this->user->all();

        Fpdf::SetFillColor(255);
        Fpdf::SetTextColor(0);
        foreach($users as $user){
        	Fpdf::Cell(32, 6, $user->id, 1, 0, 'L', true);
        	Fpdf::Cell(32, 6, $user->username, 1, 0, 'L', true);
        	Fpdf::Cell(32, 6, $user->first_name, 1, 0, 'L', true);
        	Fpdf::Cell(32, 6, $user->last_name, 1, 0, 'L', true);
        	Fpdf::Cell(32, 6, $user->contact_number, 1, 0, 'L', true);
        	Fpdf::Cell(32, 6, Sentry::findUserByID($user->id)->getGroups()[0]->name, 1, 0, 'L', true);
        	Fpdf::Ln();
        }

        Fpdf::Output();
        exit;
	}

	public function generateLocationList(){
		Fpdf::AddPage();
		Fpdf::SetFont('Courier','B',16);
                Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
                Fpdf::SetFont('Courier','',11);
                Fpdf::Cell(190,10,'Location List as of ' . Carbon::now(),0,1,'C');
                Fpdf::SetFont('Courier','','9');

        		Fpdf::SetFillColor(0);
                Fpdf::SetTextColor(255);
                Fpdf::SetFont('Courier','B');
                Fpdf::Cell(65, 10, "ID" , 1, 0, 'L', true);
                Fpdf::Cell(65, 10, "Location Name" , 1, 0, 'L', true);
                Fpdf::Cell(65, 10, "District" , 1, 0, 'L', true);
                Fpdf::Ln();

                $locations = $this->location->all();

                Fpdf::SetFillColor(255);
                Fpdf::SetTextColor(0);
                foreach($locations as $location){
                	Fpdf::Cell(65, 6, $location->id, 1, 0, 'L', true);
                	Fpdf::Cell(65, 6, $location->location_name, 1, 0, 'L', true);
                	Fpdf::Cell(65, 6, $location->district, 1, 0, 'L', true);
                	Fpdf::Ln();
                }

                Fpdf::Output();
                exit;
	}

	public function generateRouteList(){
	       Fpdf::AddPage();
		Fpdf::SetFont('Courier','B',16);
                Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
                Fpdf::SetFont('Courier','',11);
                Fpdf::Cell(190,10,'Routes List as of ' . Carbon::now(),0,1,'C');
                Fpdf::SetFont('Courier','','9');

        		Fpdf::SetFillColor(0);
                Fpdf::SetTextColor(255);
                Fpdf::SetFont('Courier','B');
                Fpdf::Cell(48, 10, "ID" , 1, 0, 'L', true);
                Fpdf::Cell(48, 10, "Route Code" , 1, 0, 'L', true);
                Fpdf::Cell(48, 10, "Route Name", 1, 0, 'L', true);
                Fpdf::Cell(48, 10, "District" , 1, 0, 'L', true);
                Fpdf::Ln();

                $routes = QRoute::all();

                Fpdf::SetFillColor(255);
                Fpdf::SetTextColor(0);
                foreach($routes as $route){
                	Fpdf::Cell(48, 6, $route->id, 1, 0, 'L', true);
                	Fpdf::Cell(48, 6, $route->route_code, 1, 0, 'L', true);
                	Fpdf::Cell(48, 6, $route->route_name, 1, 0, 'L', true);
                	Fpdf::Cell(48, 6, $route->location()->first()->district, 1, 0, 'L', true);
                	Fpdf::Ln();
                }

                Fpdf::Output();
                exit;
        	}

	public function generateAccountList(){
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

        public function generateSmsList(){
                Fpdf::AddPage();
                Fpdf::SetFont('Courier','B',16);
                Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
                Fpdf::SetFont('Courier','',11);
                Fpdf::Cell(190,10,'List of users Enrolled in SMS ' . Carbon::now(),0,1,'C');
                Fpdf::SetFont('Courier','','9');

                Fpdf::SetFillColor(0);
                Fpdf::SetTextColor(255);
                Fpdf::SetFont('Courier','B');
                Fpdf::Cell(38, 10, "Account Number" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "OEBR Number", 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "Last Name" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "First Name" , 1, 0, 'L', true);
                Fpdf::Cell(38, 10, "Contact Number" , 1, 0, 'L', true);
                Fpdf::Ln();

                $sms = AccountContact::all();

                Fpdf::SetFillColor(255);
                Fpdf::SetTextColor(0);
                foreach($sms as $sms1){
                        $account = $sms1->account()->first();
                        Fpdf::Cell(38, 6, $account->account_number, 1, 0, 'L', true);
                        Fpdf::Cell(38, 6, $account->oebr_number, 1, 0, 'L', true);
                        Fpdf::Cell(38, 6, $account->consumer()->first()->last_name, 1, 0, 'L', true);
                        Fpdf::Cell(38, 6, $account->consumer()->first()->first_name, 1, 0, 'L', true);
                        Fpdf::Cell(38, 6, $sms1->contact_number, 1, 0, 'L', true);
                        Fpdf::Ln();
                }
                Fpdf::Output();
                exit;
        }

        public function generatePaymentsByLocation(){
                $location_id =  Input::get('location');
                $location = $this->location->find($location_id);
                $payments = $this->bill->findAllPaymentsByLocation($location_id);
                Fpdf::AddPage();
                Fpdf::SetFont('Courier','B',16);
                Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
                Fpdf::SetFont('Courier','',11);
                Fpdf::Cell(190,10,'Payment For Location:  ' . $location->location_name ,0,1,'C');
                Fpdf::SetFont('Courier','','9');

                Fpdf::SetFillColor(0);
                Fpdf::SetTextColor(255);
                Fpdf::SetFont('Courier','B');
                Fpdf::Cell(45, 10, "First Name" , 1, 0, 'L', true);
                Fpdf::Cell(45, 10, "Last Name", 1, 0, 'L', true);
                Fpdf::Cell(45, 10, "Transaction Date" , 1, 0, 'L', true);
                Fpdf::Cell(45, 10, "Due Payment" , 1, 0, 'L', true);
                   Fpdf::Ln();
                
                
                Fpdf::SetFillColor(255);
                Fpdf::SetTextColor(0);

                foreach($payments as $payment){
                        Fpdf::Cell(45, 6, $payment->first_name, 1, 0, 'L', true);
                        Fpdf::Cell(45, 6, $payment->last_name, 1, 0, 'L', true);
                        Fpdf::Cell(45, 6, $payment->transaction_datetime, 1, 0, 'L', true);
                        Fpdf::Cell(45, 6, number_format($payment->payment - $payment->change,2), 1, 0, 'L', true);
                        Fpdf::Ln();
                }
                Fpdf::Output();
                exit;
        }
}