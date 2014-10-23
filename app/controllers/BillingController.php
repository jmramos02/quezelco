<?php

use Quezelco\Interfaces\BillRepository as Billing;
use Quezelco\Interfaces\AccountRepository as AccountRepo;
use Quezelco\Interfaces\RatesRepository as Rates;
use Carbon\Carbon;

class BillingController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function __construct(Billing $bill,AccountRepo $account, Rates $rates){
		$this->account = $account;
		$this->bill = $bill;
		$this->rates = $rates;
	}
	public function index()
	{
        $search_key = '';
		$bills = $this->bill->search($search_key);
		return View::make('admin.billing.index', compact('bills', 'search_key'));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function search()
    {
        $search_key = Input::get('searchKey');
        $bills = $this->bill->search($search_key);

        return View::make('admin.billing.index', compact('bills', 'search_key'));
    }

	public function enterReading($id){
		$current_date = Input::get('start_date');
		$rules = array('new_reading' =>'required|numeric',
				'start_date' => 'required|date',
				'end_date' => "required|date|after:$current_date");

		$validator = Validator::make(Input::all(), $rules);
		if($validator->fails()){
			return Redirect::to('/admin/enter-reading/' . $id)->with('id', $id)->withErrors($validator);
		}else{
			$account = $this->account->find($id);
			$this->bill->updateBilling($account, Input::all());
			return Redirect::to('admin/billing')->with('message','Bill added to customer');
		}
	}

    public function adjustReading($id)
    {
        $bill = Bill::join('accounts', 'bills.account_id', '=', 'accounts.id')
                     ->where('bills.id', '=', $id)
                     ->select('bills.id as id', 'start_date', 'end_date', 'current_reading')
                     ->first();

        return View::make('admin.billing.edit-reading')->with('bill', $bill);
    }

    public function updateReading($id)
    {
        $current_date = Input::get('start_date');
        $bill = Bill::find($id);
        $account = Account::find($bill->account_id);

        $rules = array('current_reading' =>'required|numeric',
                'start_date' => 'required|date',
                'end_date' => "required|date|after:$current_date");

        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails())
        {
            return Redirect::to('/admin/adjust-billing/' . $id)->withErrors($validator);
        }

        $this->bill->update($bill, $account, Input::all());
        return Redirect::to('admin/billing')->with('message','Bill updated to customer');
    }

	public function showEnterReadingForm($id){
		return View::make('admin.billing.reading-form')->with('id', $id);
	}

	public function showPdf($id){
        $bill = $this->bill->findNextPaymentById($id);
		$rates = $this->rates->getRates();
		$accountObject = $bill->account()->first();
		$userObject = $bill->account()->first()->consumer()->first();

		$last_name = $userObject->last_name;
		$first_name = $userObject->first_name;
		$account_number = $accountObject->account_number;
		$consumed = ($accountObject->current_reading - $accountObject->previous_reading);	
		$periodCovered = $bill->start_date . ' to '. $bill->end_date;


		$sum = 0;

		Fpdf::AddPage();
        Fpdf::SetFont('Courier','B',16);
        Fpdf::Cell(190,10,'Quezelco Electronic Cooperative',0,1,'C');
        Fpdf::SetFont('Courier','',11);
        Fpdf::Cell(190,10,'Billing Statement',0,1,'C');
        Fpdf::SetFont('Courier','','9');
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);	
        Fpdf::Cell(40,0,"Billing Statement For: " . $first_name . ', ' . $last_name );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,'Account Number: ' . $account_number );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"KWH: Consumed: $consumed"  );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"Due Date: $bill->due_date"  );
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"Period Covered From: $periodCovered");
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,"Previous Reading: " . $accountObject->previous_reading);
        Fpdf::ln(5);
        Fpdf::Cell(40,0,"Current Reading: " . $accountObject->current_reading);
        Fpdf::ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::Cell(40,0,"Date Printed: " . Carbon::now());
        Fpdf::Ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::Ln(5);
        Fpdf::SetFont('Courier','B',9);
        Fpdf::Cell(70,0,'Charges');
        Fpdf::Cell(70,0,'Rate/KW/KWH');
        Fpdf::Cell(70,0,'Amount');
        Fpdf::SetFont('Courier','','9');
        Fpdf::Ln(5);
        Fpdf::Cell(70,0,'Generation System Charge');
        Fpdf::Cell(70,0, number_format($rates->generation_system_charge,4));
        Fpdf::Cell(70,0, number_format($rates->generation_system_charge * $consumed,4));

        $sum += $rates->generation_system_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Transmission System Charge');
        Fpdf::Cell(70,0, number_format($rates->transmission_system_charge,4));
        Fpdf::Cell(70,0, number_format($rates->transmission_system_charge * $consumed,4));
        $sum += $rates->transmission_system_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'System Loss Charge');
        Fpdf::Cell(70,0, number_format($rates->system_loss_charge,4));
        Fpdf::Cell(70,0, number_format($rates->system_loss_charge * $consumed,4));
        $sum += $rates->system_loss_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Distribution System Charge');
        Fpdf::Cell(70,0, number_format($rates->dist_system_charge,4));
        Fpdf::Cell(70,0, number_format($rates->dist_system_charge * $consumed,4));
        $sum += $rates->dist_system_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Retail End User Charge');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0, number_format($rates->retail_end_user_charge,4));
        $sum += $rates->retail_end_user_charge;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Retail End User Charge');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0, number_format($rates->retail_customer_charge,4));
        $sum += $rates->retail_customer_charge;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Lifeline Subsidy');
        Fpdf::Cell(70,0, number_format($rates->lifeline_subsidy,4));
        Fpdf::Cell(70,0, number_format($rates->lifeline_subsidy * $consumed,4));
        $sum += $rates->lifeline_subsidy * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Previous Years Adjust Power Cost');
        Fpdf::Cell(70,0, number_format($rates->prev_yrs_adj_pwr_cost,4));
        Fpdf::Cell(70,0, number_format($rates->prev_yrs_adj_pwr_cost * $consumed,4));
        $sum += $rates->prev_yrs_adj_pwr_cost * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Contribution for CAPEX');
        Fpdf::Cell(70,0, number_format($rates->contribution_for_capex,4));
        Fpdf::Cell(70,0, number_format($rates->contribution_for_capex * $consumed,4));
        $sum += $rates->contribution_for_capex * $consumed;

        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',9);
        Fpdf::Cell(40,0,'Value Added Tax-----------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Generation');
        Fpdf::Cell(70,0, number_format($rates->generation_vat,4));
        Fpdf::Cell(70,0, number_format($rates->generation_vat * $consumed,4));
        $sum += $rates->generation_vat * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Transmission');
        Fpdf::Cell(70,0, number_format($rates->transmission_vat,4));
        Fpdf::Cell(70,0, number_format($rates->transmission_vat * $consumed,4));
        $sum += $rates->transmission_vat * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'System Loss');
        Fpdf::Cell(70,0, number_format($rates->system_loss_vat,4));
        Fpdf::Cell(70,0, number_format($rates->system_loss_vat * $consumed,4));
        $sum += $rates->system_loss_vat * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Distribution');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0, number_format($rates->distribution_vat,4));
        $sum += $rates->distribution_vat;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Others');
        Fpdf::Cell(70,0, number_format($rates->others,4));
        Fpdf::Cell(70,0, number_format($rates->others * $consumed,4));
        $sum += $rates->others * $consumed;
        

        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',9);
        Fpdf::Cell(40,0,'Universal Charges--------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Missionary Electrificxn');
        Fpdf::Cell(70,0, number_format($rates->missionary_electrificxn,4));
        Fpdf::Cell(70,0, number_format($rates->missionary_electrificxn * $consumed,4));
        $sum += $rates->missionary_electrificxn * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Environmental Charge');
        Fpdf::Cell(70,0, number_format($rates->environmental_charge,4));
        Fpdf::Cell(70,0, number_format($rates->environmental_charge * $consumed,4));
        $sum += $rates->environmental_charge * $consumed;

        Fpdf::ln(5);
        Fpdf::Cell(70,0,'NPC Stranded Cont Cost');
        Fpdf::Cell(70,0, number_format($rates->npc_stranded_cont_cost,4));
        Fpdf::Cell(70,0, number_format($rates->npc_stranded_cont_cost * $consumed,4));
        $sum += $rates->npc_stranded_cont_cost * $consumed;
        Fpdf::ln(5);

        Fpdf::ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',13);
        Fpdf::Cell(70,0,'Total Amount Due before Charges');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0,number_format($sum,2));
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);
	$penalty = $sum * $rates->penalty;
        $penaltyVat = $penalty * $rates->penalty;
	$sum = $sum + $penalty;
	$penalty = $penalty - $penaltyVat;
        Fpdf::ln(5);
        Fpdf::Cell(40,0,'Penalties-----------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Penalty');
	Fpdf::Cell(70,0, $rates->penalty);
	Fpdf::Cell(70,0, number_format($penalty,2));
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Penalty Vat');
        Fpdf::Cell(70,0, 0.12);
        Fpdf::Cell(70,0, number_format($penaltyVat,2));
	Fpdf::ln(5);
         Fpdf::ln(5);
        Fpdf::Cell(40,0,'Disconnection-------------------------------------------------------------------------------------');
        Fpdf::SetFont('Courier','',9);
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','',9);

	Fpdf::Cell(70,0,'Reconnection Fee');
	Fpdf::Cell(70,0, $rates->reconnection_fee);
	Fpdf::Cell(70,0, number_format(112,2));
	$sum = $sum + 112;

        Fpdf::ln(5);
        Fpdf::Cell(40,0,'--------------------------------------------------------------------------------------------------');
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','B',13);
        Fpdf::Cell(70,0,'Total Amount Due after Charges');
        Fpdf::Cell(70,0, '');
        Fpdf::Cell(70,0,number_format($sum,2));
        Fpdf::ln(5);
        Fpdf::SetFont('Courier','b',9);
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Not Valid as Official Receipt');
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'This becomes final if no complaint is received after 5 (five) days from receipt hereof');
        Fpdf::ln(5);
        Fpdf::Cell(70,0,'Please Present This statement when paying for your bill');

        Fpdf::Output();
        exit;
	}
}
