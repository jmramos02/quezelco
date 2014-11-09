@extends('admin.template')

@section('head')
	{{HTML::style('stylesheets/user-maintenance.css')}}
@stop  

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Customer Enrollment</h2>
			</div>
		</div>
		@if(Session::has('message'))
			<div class="row billing-title">
				<div class="col-md-12 column">
			</div>
		@endif
		<div class="row">
		{{Form::open(array('url' => 'admin/account/search', 'method' => 'get'))}}
			<div class="col-md-7 options-left">
				<form role="form" action="">
					<div class="form-group">
						<div class="col-md-9">
							<form role="form">
							  <div class="form-group">
							    <div class="input-group">
							    	<div class="input-group-addon"><i class="fa fa-search"></i></div>
							    	{{Form::text('search_key','',array('class' => 'form-control','id' => 'search-user-logs', 'placeholder' => 'Search'))}}
							    </div>
							  </div>
							</form>
						</div>
						<div class="col-md-3 search-btn-container">
								{{Form::submit('Search',array('class' => 'btn btn-primary'))}}
						</div>
					</div>
				</div>
			{{Form::close()}}
		</div>
		<div class="row">
			<table class="responsive">
			  <thead>
			    <tr class = "normal">
			      <th>#</th>
			      <th>Account Number</th>
			      <th>Meter Number</th>
			      <th>First Name</th>
			      <th>Last Name</th>
			      <th>Brgy</th>
			      <th>Status</th>
			      <th>Current Reading</th>
			      <th>Previous Reading</th>
			      <th>View Billing History</th>
			      <th>Change Status</th>
			      <th>Edit Information</th>
			      <th>Enter Reading</th>
			    </tr>
			  </thead>
			  <tbody>
			  @foreach($accounts as $account)
			    <tr>
			      <td>{{$account->id}}</td>
			      <td>{{$account->account_number}}</td>
			      <td>{{$account->meter_number}}</td>
			      <td>{{$account->consumer()->first()->first_name}}</td>
			      <td>{{$account->consumer()->first()->last_name}}</td>
			      <td>{{$account->routes()->first()->route_name}}</td>
			      <td>
			      	@if($account->status == 1)
						<p class = "ok">Connected</p>
			      	@else
						<p class = "error">Disconnected</p>
			      	@endif
			      </td>
			      <td>{{number_format($account->current_reading,2)}}</td>
			      <td>{{number_format($account->previous_reading,2)}}</td>
			      <td>{{HTML::link('admin/view-billing-history/' . $account->id,'View',array('style' => 'color:green'))}}</td>
			      <td>{{HTML::link('admin/change-status/' . $account->id,'Change Status',array('style' => 'color:green'))}}</td>
			      <td>{{HTML::link('admin/account/' . $account->id . '/edit','Edit Information',array('style' => 'color:green'))}}</td>
			    	<td>
			    		{{HTML::link('admin/enter-reading/' . $account->id, 'Enter Reading', array('style' => 'color:green'))}}
			    	</td>
			   	</tr>
			   @endforeach
			  </tbody>
			</table>
			{{$accounts->appends(array('search_key' => $search_key))->links()}}
				<h3>Send Textblast to All Enrolled Accounts</h3>
				{{Form::open(array('url' => 'admin/accounts/textblast'))}}
					<div class="error">{{$errors->first('message')}}</div>
					{{Form::textarea('message','',array('maxlength' => '160'))}}
					{{Form::submit('Send',array('class' => 'btn btn-primary btn-lg'))}}
				{{Form::close()}}
		</div>

		
	</div>
@stop