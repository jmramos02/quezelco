<?php
namespace Quezelco\Eloquent;

use Quezelco\Interfaces\RatesRepository;
use WheelingRates;
use Validator;

class EloquentRatesRepository implements RatesRepository{
	
	public function getRates(){
		return WheelingRates::find(1);
	}

	public function update($inputs){
		$rates = WheelingRates::find(1);
		$rates->generation_system_charge = $inputs['generation_system_charge'];
		$rates->transmission_system_charge = $inputs['transmission_system_charge'];
		$rates->system_loss_charge = $inputs['system_loss_charge'];
		$rates->dist_system_charge = $inputs['dist_system_charge'];
		$rates->retail_end_user_charge = $inputs['retail_end_user_charge'];
		$rates->retail_customer_charge = $inputs['retail_customer_user_charge'];
		$rates->lifeline_subsidy = $inputs['lifeline_subsidy'];
		$rates->prev_yrs_adj_pwr_cost = $inputs['prev_yrs_adj_pwr_cost'];
		$rates->contribution_for_capex = $inputs['contribution_for_capex'];
		$rates->generation_vat = $inputs['generation_vat'];
		$rates->transmission_vat = $inputs['transmission_vat'];
		$rates->distribution_vat =  $inputs['distribution_vat'];
		$rates->system_loss_vat =  $inputs['system_loss_vat'];
		$rates->others =  $inputs['others'];
		$rates->missionary_electrificxn = $inputs['missionary_electrificxn'];
		$rates->environmental_charge = $inputs['environmental_charge'];
		$rates->npc_stranded_cont_cost = $inputs['npc_stranded_cont_cost'];
		$rates->sr_citizen_subsidy = $inputs['sr_citizen_subsidy']; 	
		return $rates->save();
	}

	public function validate($inputs){
		$rules = array(
			'generation_system_charge' => 'required|numeric',
			'transmission_system_charge' => 'required|numeric',
			'system_loss_charge' =>  'required|numeric',
			'dist_system_charge' => 'required|numeric',
			'retail_end_user_charge' => 'required|numeric',
			'retail_customer_charge' => 'required|numeric',
			'lifeline_subsidy' => 'required|numeric',
			'prev_yrs_adj_pwr_cost' => 'required|numeric',
			'contribution_for_capex' => 'required|numeric',
			'generation_vat'=>'required|numeric',
			'transmission_vat' => 'required|numeric',
			'distribution_vat' => 'required|numeric',
			'system_loss_vat' => 'required|numeric',
			'others' => 'required|numeric',
			'missionary_electrificxn' => 'required|numeric',
			'environmental_charge' => 'required|numeric',
			'npc_stranded_cont_cost' => 'required|numeric',
			'sr_citizen_subsidy' => 'required|numeric',
			'username' => 'required',
			'password' => 'required'
		);

		return Validator::make($inputs, $rules);
	}

} 