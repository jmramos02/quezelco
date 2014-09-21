@extends('cashier.template')
@section('head')
	{{HTML::style("stylesheets/cashier.css")}}
@stop
@section('content')

	<!-- Main Content -->
	
	<div class="container">
		@if(Session::has('message'))
			<div class="row billing-title">
				<div class="col-md-12 column">
			</div>
		@endif
		<h2>Cashier</h2>
		<div class="col-md-12">
			{{Form::open(array('url' =>'cashier/payment/search-oebr'))}}
			<div class="error">{{$errors->first('oebr')}}</div>
			<div class="col-md-12">
				<h6>OEBR</h6>
				{{Form::text('oebr','',array('class' => 'form-control'))}}
			</div>
			<div class="col-md-12">	
				<input type="submit" class="btn btn-primary btn-lg" value="Search">
			</div>
			{{Form::close()}}
		</div>
	</div>
@stop