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
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>To be Collected Per Town</h6>
				{{Form::open(array('url' => 'admin/reports/tobecollected-per-location'))}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>Collection By Date</h6>
				{{Form::open(array('url' => 'admin/reports/collection-by-date'))}}
					{{Form::label('from','From')}}
					{{Form::text('dtfrom','',array('class' => 'datepicker'))}}
					{{Form::label('to','To')}}
					{{Form::text('dtto','',array('class' => 'datepicker'))}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>Disconnected Per Town</h6>
				{{Form::open(array('url' => 'admin/reports/disconnected-per-town'))}}
					{{Form::label('location','Select Location')}}
					{{Form::select('location',$locations)}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>Connected Per Town</h6>
				{{Form::open(array('url' => 'admin/reports/connected-per-town'))}}
					{{Form::label('location','Select Location')}}
					{{Form::select('location',$locations)}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>Consumer with Penalty Per Town</h6>
				{{Form::open(array('url' => 'admin/reports/penalty-per-town'))}}
					{{Form::label('location','Select Location')}}
					{{Form::select('location',$locations)}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
				<h6>CSV Backup</h6>
				{{Form::open(array('url' => 'admin/reports/backup'))}}
					{{Form::label('table','Select Table to be backed up')}}
					{{Form::select('table',$tables)}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}
			</div>
		</div>
@stop