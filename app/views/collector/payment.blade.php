@extends('collector.template')
@section('head')
	{{HTML::style("stylesheets/collector.css")}}
@stop
@section('content')

	<!-- Main Content -->
	
	<div class="container">
		
		<h2>Collector</h2>
		<div class="col-md-12">
		<div class="error">{{$errors->first('payment')}}</div>
		@if(Session::has('error_message'))
			<div class="error">{{Session::get('error_message')}}</div>
		@endif
		{{Form::open(array('url' =>'collector/accept-payment/' . $bill->id .'?oebr=' . $oebr))}}
			<div class="col-md-4">
				<h6>Oebr Number</h6>
				{{Form::text('last_name', $bill->account()->first()->oebr_number,array('class' => 'form-control', 'id' => 'change', 'readonly' => 'true'))}}
			</div>
			<div class="col-md-4">
				<h6>First Name</h6>
				{{Form::text('first_name', $bill->account()->first()->consumer()->first()->first_name,array('class' => 'form-control', 'id' => 'change', 'readonly' => 'true'))}}
			</div>
			<div class="col-md-4">
				<h6>Last Name</h6>
				{{Form::text('last_name', $bill->account()->first()->consumer()->first()->last_name,array('class' => 'form-control', 'id' => 'change', 'readonly' => 'true'))}}
			</div>
			<div class="col-md-4">
				<h6>Due Date</h6>
				{{Form::text('last_name', $bill->due_date,array('class' => 'form-control', 'id' => 'change', 'readonly' => 'true'))}}
			</div>
			<div class="col-md-4">
				<h6>Total Due</h6>
				{{Form::text('due_payment', number_format($payment,2),array('class' => 'form-control', 'id' => 'change', 'readonly' => 'true'))}}
			</div>
			 <div class="col-md-4">
				<h6>Enter Payment</h6>
				{{Form::text('payment','',array('class' => 'form-control', 'id' => 'payment'))}}
			</div>
			<div class="col-md-12">	
				<input type="submit" class="btn btn-primary btn-lg" value="Save">
			</div>
		{{Form::close()}}
		</div>
	</div>
@stop