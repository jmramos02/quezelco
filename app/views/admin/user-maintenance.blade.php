@extends('admin.template')

@section('head')
	{{HTML::style('stylesheets/user-maintenance.css')}}
@stop  

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>User Maintenance</h2>
			</div>
		</div>
		@if(Session::has('message'))
			<div class="row billing-title">
				<div class="col-md-12 column">
					<p class="notification">{{Session::get('message')}}</p>
				</div>
			</div>
		@endif
		<div class="row">
		{{Form::open(array('url' => 'admin/search-user', 'method' => 'get'))}}
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
			<div class="col-md-5 options-left">
				<div class="btn btn-primary"><a href="{{URL::to('admin/add-user')}}"><i class="fa fa-plus"></i> Add User</a></div>
			</div>
		</div>

		<div class="row">
			<table class="responsive">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Username</th>
			      <th>First Name</th>
			      <th>Last Name</th>
			      <th>Contact Number</th>
			      <th>Last Login</th>
			      <th>Role</th>
			      <th>Activated</th>
			      <th>Location</th>
			      <th>Action</th>
			      <th>Edit</th>
			      <th>Deactivate</th>
			    </tr>
			  </thead>
			  <tbody>
			  @foreach($users as $user)
			    <tr class = "normal">
			      <td>{{$user->id}}</td>
			      <td>{{$user->username}}</td>
			      <td>{{$user->first_name}}</td>
			      <td>{{$user->last_name}}</td>
			      <td>{{$user->contact_number}}</td>
			      <td> 
			      	@if($user->last_login == null)
						No logins yet
			      	@else
						{{$user->last_login}}
			      	@endif
			      </td>
			      <td>{{Sentry::findUserByID($user->id)->getGroups()[0]->name}}</td>
			      <td>
			      	@if($user->activated == 1)
			      		Yes
			      	@else
			      		No
			      	@endif
			      </td>
			      <td>
			      	@foreach($user->locations as $location)	
						<ul>
							<li class = "normal">{{$location->location_name}}</li>
						</ul>
			      	@endforeach
			      </td>
			      <td>
			      		@if(Sentry::findUserByID($user->id)->getGroups()[0]->name == 'Area Manager')
							{{HTML::link('admin/add-location/' . $user->id,'Add Location',array('style'=>'color:green'))}}
						@elseif(Sentry::findUserById($user->id)->getGroups()[0]->name == 'Consumer')
							{{HTML::link('admin/add-account/' . $user->id,'Add Accounts',array('style'=>'color:green'))}}
			      		@endif
				  </td>	
			      <td>{{HTML::link('admin/edit-user/' . $user->id, 'Edit', array('style' => 'color:green'))}}</td>
			      <td>
					@if($user->activated == 1)
			      		{{HTML::link('admin/activation-user/' . $user->id, 'Deactivate', array('style' => 'color:green'))}}
			      	@else
			      		{{HTML::link('admin/activation-user/' . $user->id, 'Activate', array('style' => 'color:green'))}}
			      	@endif
			      </td>
			    </tr>
			   @endforeach
			  </tbody>
			</table>
			{{ $users->appends(array('search_key' => $search_key))->links() }}
		</div>
	</div>
@stop