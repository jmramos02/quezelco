@extends('admin.template')
@section('content')
	<div class="container">
		<div class="col-md-12 my-account-title">
				<h2>Other Reports</h2>
		</div>
			<div class="col-md-12">
				<div class="col-md-4">
					<h6>User List</h6>
					<li>{{HTML::link('admin/reports/user-list','Print', array('class' => 'btn btn-primary'))}}</li>
				</div>

				<div class="col-md-4">	
					<h6>Location List</h6>
		      		<li>{{HTML::link('admin/reports/location-list','Print',array('class' => 'btn btn-primary'))}}</li>
				</div>
				
				<div class="col-md-4">
					<h6>List of Brgy's</h6>
		     	 	<li>{{HTML::link('admin/reports/route-list',"Print",array('class' => 'btn btn-primary'))}}</li>
				</div>

				<div class="col-md-4">
						<h6>Consumer List</h6>
		      		<li>{{HTML::link('admin/reports/consumer-list', 'Print',array('class' => 'btn btn-primary'))}}</li>
				</div>

				<div class="col-md-4">
					<h6>List of SMS Enrolled Accounts</h6>
		      		<li>{{HTML::link('admin/reports/sms-list', 'Print',array('class' => 'btn btn-primary'))}}</li>
				</div>

				<div class="col-md-4">
					<h6>List of User Logs</h6>
		      		<li>{{HTML::link('admin/reports/user-logs', 'Print',array('class' => 'btn btn-primary'))}}</li>
				</div>
		
				<!--<h6>To be Collected Per Town</h6>
				{{Form::open(array('url' => 'admin/reports/tobecollected-per-location'))}}
					{{Form::submit('Print',array('class' => 'btn btn-primary'))}}
				{{Form::close()}}-->
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