@extends('admin.template')
@section('content')
	<div class="container">
		<div class="col-md-12 my-account-title">
				<h2>Other Reports</h2>
		</div>
			<div class="col-md-12">
				<h6>Collection Per Location</h6>
				{{Form::open(array('url' => 'admin/reports/collection-per-location'))}}
					{{Form::label('location','Select Location')}}
					{{Form::select('location',$locations)}}
					{{Form::submit('Go',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>Collection By Date</h6>
				{{Form::open(array('url' => 'admin/reports/collection-by-date'))}}
					{{Form::label('from','From')}}
					{{Form::text('from','',array('class' => 'datepicker'))}}
					{{Form::label('to','To')}}
					{{Form::text('to','',array('class' => 'datepicker'))}}
					{{Form::submit('Go',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
			</div>
		</div>
@stop