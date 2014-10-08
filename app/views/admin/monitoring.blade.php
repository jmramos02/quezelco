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
		</div>
			<div class="col-md-12">
				<h6>Billing Statistics</h6>
				<p class = "notification">Showing this year's billing statistics</p>
				<canvas id="myChart" width="200" height="200"></canvas>
			</div>
		</div>
		{{HTML::script('scripts/chart.js')}}
@stop