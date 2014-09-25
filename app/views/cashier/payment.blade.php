@extends('cashier.template')
@section('head')
	{{HTML::style("stylesheets/cashier.css")}}
@stop
@section('content')

	<!-- Main Content -->
	
	<div class="container">
		
		<h2>Cashier</h2>
		<div class="col-md-12">
		{{Form::open(array('url' =>'cashier/accept-payment/' . $bill->id))}}
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
				{{Form::text('due_payment', number_format($bill->total_payment,2),array('class' => 'form-control', 'id' => 'change', 'readonly' => 'true'))}}
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