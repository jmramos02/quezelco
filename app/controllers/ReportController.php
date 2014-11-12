<?php
use Carbon\Carbon;
use Quezelco\Interfaces\AccountRepository as Account;
use Quezelco\Eloquent\EloquentUserRepository as User;
use Quezelco\Eloquent\EloquentLocationRepository as Location;
use Quezelco\Eloquent\EloquentRoutesRepository as QRoutes;
use Quezelco\Eloquent\EloquentBillRepository as Bill;

class ReportController extends BaseController{

	public function __construct(User $user, Location $location, Qroutes $route, Account $account, Bill $bill, Logging $log){
		$this->location = $location;
		$this->user = $user;
		$this->route = $route;
		$this->account = $account;
        $this->bill = $bill;
        $this->log = $log;
	}

    public function generateBackup(){
        $table = Input::get('table');
        $chingchong = DB::table($table)->get();
        $output = '';
        foreach ($chingchong as $row) {
            $output .= implode(",",(array) $row);
        }
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="ExportFileName.csv"',
        );
 
        return Response::make(rtrim($output, "\n"), 200, $headers);

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
        Fpdf::Cell(190,10,'List of users Registered in SMS ' . Carbon::now(),0,1,'C');
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

    public function generatetobePaymentsByLocation()
    {
        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Payment For Locations To Be Collected',0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(95, 10, "Location Name" , 1, 0, 'L', true);
        Fpdf::Cell(95, 10, "Amount", 1, 0, 'L', true);
        Fpdf::Ln();
        
        
        Fpdf::SetFillColor(255);
        Fpdf::SetTextColor(0);


        $locations = $this->location->all();

        foreach ($locations as $loc) 
        {
            Fpdf::Cell(95, 7, $loc->location_name, 1, 0, 'L', true);
            $payments = $this->bill->findAllPaymentsByLocation($loc->id);
            $sumOfAllPayments = 0;
            foreach ($payments as $payment) 
            {
                $sumOfAllPayments = $payment->payment - $payment->change;
            }
            Fpdf::Cell(95, 7, number_format($sumOfAllPayments,2), 1, 0, 'L', true);
            Fpdf::Ln();
        }

        Fpdf::Output();
        exit;
    }

    public function generatePaymentsByDate()
    {
        $dtFrom = date('Y-m-d', strtotime(Input::get('dtfrom')));
        $dtTo = date('Y-m-d', strtotime(Input::get('dtto')));

        $payments = $this->bill->findAllpaymentsByDates($dtFrom, $dtTo);

        

        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Payments From Date: ' . date('F d, Y', strtotime($dtFrom)) . ' to ' . date('F d, Y', strtotime($dtTo)),0,1,'C');
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

    public function generateUserLogs()
    {
        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'List of Users who logged in/out in the system as of ' . Carbon::now(),0,1,'C');
        Fpdf::SetFont('Courier','','9');


        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(32, 10, "ID" , 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "Username" , 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "Last Name" , 1, 0, 'L', true);
        Fpdf::Cell(32 ,10, 'Status', 1, 0, 'L', true);
        Fpdf::Cell(32, 10, "Role" , 1, 0, 'L', true);
        Fpdf::Ln();

        $logs = $this->log->all();

        foreach($logs as $log){

            if(($log->status) == 1)
            {
                $status = "Logged In";
            }
            else
            {
                $status = "Logged Out";
            }

            Fpdf::SetFillColor(255);
            Fpdf::SetTextColor(0);
            Fpdf::Cell(32, 6, $log->id, 1, 0, 'L', true);
            Fpdf::Cell(32, 6, $log->user()->first()->username, 1, 0, 'L', true);
            Fpdf::Cell(32, 6, $log->user()->first()->first_name, 1, 0, 'L', true);
            Fpdf::Cell(32, 6, $log->user()->first()->last_name, 1, 0, 'L', true);
            Fpdf::Cell(32, 6, $status, 1, 0, 'L', true);
            Fpdf::Cell(32, 6, Sentry::findUserByID($log->user()->first()->id)->getGroups()[0]->name, 1, 0, 'L', true);
            Fpdf::Ln();
        }

        Fpdf::Output();
        exit;

    }

    public function generateDisconnectedPerTown()
    {
        $location_id =  Input::get('location');
        $location = $this->location->find($location_id);
        $results = $this->location->findDisconnectedConnectedAccounts($location->id, 0);


        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Disconnected at Location:  ' . $location->location_name,0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(45, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "Last Name", 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "OEBR NUMBER" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "ROUTE NAME" , 1, 0, 'L', true);
        Fpdf::Ln();
        
        
        foreach($results as $result)
        {
            Fpdf::SetFillColor(255);
            Fpdf::SetTextColor(0);

            Fpdf::Cell(45, 6, $result->firstname, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->lastname, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->oebrnumber, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->routename, 1, 0, 'L', true);
            Fpdf::Ln();
        }
        Fpdf::Output();
        exit;
    }

    public function generateConnectedPerTown()
    {
        $location_id =  Input::get('location');
        $location = $this->location->find($location_id);
        $results = $this->location->findDisconnectedConnectedAccounts($location->id, 1);

        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Connected at Location:  ' . $location->location_name,0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(45, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "Last Name", 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "OEBR NUMBER" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "ROUTE NAME" , 1, 0, 'L', true);
        Fpdf::Ln();
        

        foreach($results as $result)
        {
            Fpdf::SetFillColor(255);
            Fpdf::SetTextColor(0);

            Fpdf::Cell(45, 6, $result->firstname, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->lastname, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->oebrnumber, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->routename, 1, 0, 'L', true);
            Fpdf::Ln();
        }
        Fpdf::Output();
        exit;
    }

    public function generatePenaltyPerTown()
    {
        $location_id =  Input::get('location');
        $location = $this->location->find($location_id);
        $results = $this->bill->findAllWithPenalty($location->id);

        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Consumers with Penalty at Location:  ' . $location->location_name,0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(0);
        Fpdf::SetTextColor(255);
        Fpdf::SetFont('Courier','B');
        Fpdf::Cell(45, 10, "First Name" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "Last Name", 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "OEBR NUMBER" , 1, 0, 'L', true);
        Fpdf::Cell(45, 10, "ROUTE NAME" , 1, 0, 'L', true);
        Fpdf::Ln();
        

        foreach($results as $result)
        {
            Fpdf::SetFillColor(255);
            Fpdf::SetTextColor(0);

            Fpdf::Cell(45, 6, $result->firstname, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->lastname, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->oebrnumber, 1, 0, 'L', true);
            Fpdf::Cell(45, 6, $result->routename, 1, 0, 'L', true);
            Fpdf::Ln();
        }
        Fpdf::Output();
        exit;
    }

    public function viewRatesHistory(){
        $history = RatesHistory::find(Input::get('rates_history'));
        $rates = json_decode($history->rates,true);
        Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Rates as of ' . $history->before_date,0,1,'C');
        Fpdf::SetFont('Courier','','9');

        Fpdf::SetFillColor(255);
        Fpdf::SetTextColor(0);

        Fpdf::Cell(100,5,'Generation System Charge: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['generation_system_charge'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Transmission System Charge: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['transmission_system_charge'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'System Loss Charge: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['system_loss_charge'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Distribution System Charge: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['dist_system_charge'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Retail End User Charge: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['retail_end_user_charge'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Retail Customer Charge: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['retail_customer_charge'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Lifeline Subsidy: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['lifeline_subsidy'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Previous Years Adjust Power Cost: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['prev_yrs_adj_pwr_cost'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Contribution For Capex:',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['contribution_for_capex'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Generation Vat',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['generation_vat'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Transmission Vat:',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['transmission_vat'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'System Loss Vat: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['system_loss_vat'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Distribution Vat: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['distribution_vat'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Others:  ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['others'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Missionary Electrification:  ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['missionary_electrificxn'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Environmental Charge:  ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['environmental_charge'],0,0,'L',true);
         Fpdf::Ln();
        Fpdf::Cell(100,5,'Npc Stranded Cont Cost: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['npc_stranded_cont_cost'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Senior Citizen Subsidy: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['sr_citizen_subsidy'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Penalty: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['penalty'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Reconnection Fee: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['reconnection_fee'],0,0,'L',true);
        Fpdf::Ln();
        Fpdf::Cell(100,5,'Remarks: ',0,0,'L',true);
        Fpdf::Cell(80,5,$rates['remarks'],0,0,'L',true);
        Fpdf::Output();
        exit;
    }
}