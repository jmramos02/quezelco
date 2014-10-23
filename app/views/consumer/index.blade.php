@extends('consumer.template')
@section('head')
	{{HTML::style("stylesheets/cashier.css")}}
@stop
@section('content')

	<!-- Main Content -->
	
	<div class="container">
		<h1>Welcome! {{$user->last_name}}, {{$user->first_name}}</h1>
		<h6>List of Accounts</h6>
		<table class="responsive">
			  <thead>
			    <tr class = "normal">
			      <th>#</th>
			      <th>Account Number</th>
			      <th>Meter Number</th>
			      <th>Brgy</th>
			      <th>Status</th>
			      <th>Current Reading</th>
			      <th>Previous Reading</th>
				  <th>Register for SMS</th>			      
			    </tr>
			  </thead>
			  <tbody>
			  @foreach($accounts as $account)
			    <tr>
			      <td>{{$account->id}}</td>
			      <td>{{$account->account_number}}</td>
			      <td>{{$account->meter_number}}</td>
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
			      <td>{{HTML::link('consumer/enroll/' . $account->id, 'Register For SMS')}}</td>
			   	</tr>
			   @endforeach
			  </tbody>
			</table>
		@if(Session::has('message'))
			<div class="row billing-title">
				<div class="col-md-12 column">
					<p class="notification">{{Session::get('message')}}</p>
				</div>
			</div>
		@endif
	</div>
@stop