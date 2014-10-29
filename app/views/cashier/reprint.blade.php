@extends('cashier.template')
@section('head')
	{{HTML::style("stylesheets/cashier.css")}}
@stop
@section('content')

	<!-- Main Content -->
	
	<div class="container">
		<h2>Reprint</h2>
		<div class="col-md-12">
			{{Form::open(array('url' =>'cashier/reprint'))}}
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
		@if(Session::has('message'))
			<div class="row billing-title">
				<div class="col-md-12 column">
					<p class="notification">{{Session::get('message')}}</p>
				</div>
			</div>
		@endif
	</div>
@stop