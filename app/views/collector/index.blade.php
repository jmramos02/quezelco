@extends('collector.template')
@section('head')
	{{HTML::style("stylesheets/collector.css")}}
@stop
@section('content')

	<!-- Main Content -->
	
	<div class="container">
		<h2>Collector</h2>
		<div class="col-md-12">
			{{Form::open(array('url' =>'collector/payment/search-oebr', 'method' => 'get'))}}
			<div class="error">{{$errors->first('oebr')}}</div>
			<div class="col-md-6">
				<h6>OEBR</h6>
				{{Form::text('oebr','',array('class' => 'form-control'))}}
			</div>
			<div class="col-md-6">
				<h6>Senior Citizen ?</h6>
				{{Form::checkbox('is_senior',null,false)}}
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