<?php
class WheelingRatesSeeder extends Seeder{
	public function run(){
		DB::table('wheeling_rates')->delete();
		$rates = new WheelingRates();
		$rates->generation_system_charge = 4.5804;
		$rates->transmission_system_charge = 1.6521;
		$rates->system_loss_charge = 1.0420;
		$rates->dist_system_charge = 0.7595;
		$rates->retail_end_user_charge = 42.92;
		$rates->retail_customer_charge = 35.94;
		$rates->lifeline_subsidy = 0.1454;
		$rates->prev_yrs_adj_pwr_cost = -0.0486;
		$rates->contribution_for_capex = -0.71;
		$rates->generation_vat = 0.4788;
		$rates->transmission_vat = 0.0038;
		$rates->distribution_vat =  114.16;
		$rates->system_loss_vat =  0.0073;
		$rates->others =  0.1200;
		$rates->missionary_electrificxn = 0.1561;
		$rates->environmental_charge = 0.0025;
		$rates->npc_stranded_cont_cost = 0.1938;
		$rates->sr_citizen_subsidy = 0.0004;	
		$rates->penalty = 0.0005;
		$rates->save();
	}
}