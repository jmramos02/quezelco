@extends('admin.template')

@section('head')
	{{HTML::style('stylesheets/wheeling-rates.css')}}
@stop

@section('content')
	<!-- Main Content -->
	<div class="container">
		<div class="col-md-4">
			<div class="error">{{$errors->first('username')}}</div>
			<div class="error">{{$errors->first('password')}}</div>
		</div>
	</div>
	<div class="container">
		{{Form::model($rates, array('url' => 'admin/wheeling-rates','role' => 'form'))}}	
		<div class="col-md-12">
			<h2>Wheeling Rates</h2>
		</div>
		
		@if(Session::has('error_message'))
			<div class="col-md-4 ">
				<p class="error">{{Session::get('error_message')}}</p>
			</div>
		@endif

		@if(Session::has('message'))
			<div class="col-md-4 ">
				<p class="notification">{{Session::get('message')}}</p>
			</div>
		@endif


		<div class="col-md-12">
			<h5>CHARGES</h5>
			
			<div class="col-md-4">
				<h6>Generation System Charge</h6>
				{{Form::text('generation_system_charge',$rates->generation_system_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('generation_system_charge')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Transmission System Charge</h6>
				{{Form::text('transmission_system_charge',$rates->transmission_system_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('transmission_system_charge')}}</div>
			</div>

			<div class="col-md-4">
				<h6>System Loss Charge</h6>
				{{Form::text('system_loss_charge',$rates->system_loss_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('system_loss_charge')}}</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-4">
				<h6>Distribution System Charge</h6>
				{{Form::text('dist_system_charge',$rates->dist_system_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('dist_system_charge')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Retail End User Charge</h6>
				{{Form::text('retail_end_user_charge',$rates->retail_end_user_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('retail_end_user_charge')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Retail Customer Charge</h6>
				{{Form::text('retail_customer_charge',$rates->retail_customer_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('retail_customer_charge')}}</div>
			</div>
		</div>
		<div class="col-md-12">
			
			<div class="col-md-4">
				<h6>Life Line Subsidy</h6>
				{{Form::text('lifeline_subsidy',$rates->lifeline_subsidy,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('lifeline_subsidy')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Prv Yrs Adj-Pwr Cost</h6>
				{{Form::text('prev_yrs_adj_pwr_cost',$rates->prev_yrs_adj_pwr_cost,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('prev_yrs_adj_pwr_cost')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Contribution for Capex</h6>
				{{Form::text('contribution_for_capex',$rates->contribution_for_capex,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('contribution_for_capex')}}</div>
			</div>
		</div>


		<div class="col-md-12">
			<h5>Value Added Tax</h5>
			
			<div class="col-md-4">
				<h6>Generation</h6>
				{{Form::text('generation_vat',$rates->generation_vat,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('generation_vat')}}</div>
			</div>	

			<div class="col-md-4">
				<h6>Transmission</h6>
				{{Form::text('transmission_vat',$rates->transmission_vat,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('transmission_vat')}}</div>	
			</div>

			<div class="col-md-4">
				<h6>System Loss</h6>
				{{Form::text('system_loss_vat',$rates->system_loss_vat,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('system_loss_vat')}}</div>
			</div>
		</div>
		
		<div class="col-md-12">
			
			<div class="col-md-4">
				<h6>Distribution</h6>
				{{Form::text('distribution_vat',$rates->distribution_vat,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('distribution_vat')}}</div>
			</div>	

			<div class="col-md-4">
				<h6>Others</h6>
				{{Form::text('others',$rates->others,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('others')}}</div>
			</div>
		</div>
		<div class="col-md-12">
			<h5>Universal Charges</h5>
			
			<div class="col-md-4">
				<h6>Missionary Electrification</h6>
				{{Form::text('missionary_electrificxn',$rates->missionary_electrificxn,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('missionary_electrificxn')}}</div>
			</div>	

			<div class="col-md-4">
				<h6>Environmental Charge</h6>
				{{Form::text('environmental_charge',$rates->environmental_charge,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('environmental_charge')}}</div>
			</div>

			<div class="col-md-4">
				<h6>NPC Stranded Cont. Cost</h6>
				{{Form::text('npc_stranded_cont_cost',$rates->npc_stranded_cont_cost,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('npc_stranded_cont_cost')}}</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-4">
				<h6>Senior Citizen Subsidy</h6>
				{{Form::text('sr_citizen_subsidy',$rates->sr_citizen_subsidy,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('sr_citizen_subsidy')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Penalty</h6>
				{{Form::text('penalty',$rates->penalty,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('penalty')}}</div>
			</div>

			<div class="col-md-4">
				<h6>Reconnection Fee</h6>
				{{Form::text('reconnection_fee',$rates->reconnection_fee,array('class' => 'form-control'))}}
				<div class="error">{{$errors->first('reconnection_fee')}}</div>
			</div>
		</div>	
		<div class="col-md-12">
			<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"> Save </button>
		</div>
			<div class="modal fade modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-sm">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="myModalLabel">Need CAD Account Override</h4>
		      </div>
		      <div class="modal-body">
		      	{{Form::label('username','Username')}}
		        {{Form::text('username','',array('maxlength' => '10'))}}
		        {{Form::label('password','Password')}}
		        {{Form::password('password',array('maxlength' => '10'))}}
		      </div>
		      <div class="modal-footer">
		        <input type="submit" class="btn btn-primary btn-lg" value="Approve">
		        <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">Disapprove</button>
		      </div>
		    </div>
		  </div>
		</div>
		{{Form::close()}}
		<!-- Modal -->
	</div>

@stop