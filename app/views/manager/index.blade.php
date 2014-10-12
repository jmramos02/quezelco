@extends('manager.template')
@section('head')
	{{HTML::style("stylesheets/index.css")}}
@stop

@section('content')
	
	<div class="container">
		<h2>Manager's Module</h2>
		@if(Session::has('message'))
			<div class="row billing-title">
				<p class = "notification">{{Session::get('message')}}</p>
			</div>
		@endif
		<div class="row">
		{{Form::open(array('url' => 'manager/search', 'method' => 'get'))}}
			<div class="col-md-7 options-left">
				<form role="form" action="">
					<div class="form-group">
						<div class="col-md-9">
							<form role="form">
							  <div class="form-group">
							    <div class="input-group">
							    	<div class="input-group-addon"><i class="fa fa-search"></i></div>
							    	{{Form::text('search_key','',array('class' => 'form-control','id' => 'search-user-logs', 'placeholder' => 'Enter OEBR Number'))}}
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
			      <th>OEBR</th>
			      <th>Print Billing Statement</th>
			      <th>Change Status</th>

			    </tr>
			  </thead>
			  <tbody>
			  @foreach($users as $user)
			    <tr>
			    <td>{{$user->consumer()->first()->id}}</td>
			      <td>{{$user->consumer()->first()->account_number}}</td>
			      <td>{{$user->consumer()->first()->meter_number}}</td>
			      <td>{{$user->first_name}}</td>
			      <td>{{$user->last_name}}</td>
			      <td>{{$user->consumer()->first()->routes()->first()->route_name}}</td>
			      <td>
			      	@if($user->consumer()->first()->status == 1)
						<p class = "ok">Connected</p>
			      	@else
						<p class = "error">Disconnected</p>
			      	@endif
			      </td>
			      <td>{{$user->consumer()->first()->oebr_number}}</td>
			     <td>{{HTML::link('manager/print-billing-statement/' . $user->consumer()->first()->id, 'Print', array('style' => 'color:green'))}}</td>
			      <td>{{HTML::link('manager/change-status/' . $user->consumer()->first()->id,'Change Status',array('style' => 'color:green'))}}</td>
			   	</tr>
			   @endforeach
			  </tbody>
			</table>
			{{$users->appends(array('search_key' => $search_key))->links()}}
		</div>
	</div>
@stop