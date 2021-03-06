@extends('admin.template')
@section('head')
	{{HTML::style("stylesheets/billing.css")}}
@stop
@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Monitoring</h2>
			</div>
			<div class = "col-md-6">
				<h6>Choose Location</h6>
				{{Form::select('location',$locations,null, array('class' => 'location'))}}
				<button class = "btn btn-primary location-button">Go</button>
			</div>
			<div class="col-md-6">
				<h6>Current Customer Statistics</h6>
				<p class = "notification">Connection Status</p>
				<canvas id="myChart" width="300" height="300"></canvas>
			</div>

			<div class="col-md-6">
				<h6>Billing Status</h6>
				<canvas id="bill-status" width="300" height="300"></canvas>
			</div>
			<div class="col-md-6">
				<h6>Payment History (Current Year)</h6>
				<canvas id="payment-history" width = "300" height = "300"></canvas>
			</div>
		</div>
	</div>
@stop