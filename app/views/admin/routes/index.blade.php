@extends('admin.template')

@section('head')
	{{HTML::style('stylesheets/user-maintenance.css')}}
@stop  

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Routes Setup</h2>
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
		{{Form::open(array('url' => 'admin/routes/search', 'method' => 'get'))}}
			<div class="col-md-7 options-left">
				<form role="form" action="">
					<div class="form-group">
						<div class="col-md-9">
							<form role="form">
							  <div class="form-group">
							    <div class="input-group">
							    	<div class="input-group-addon"><i class="fa fa-search"></i></div>
							    	{{Form::text('search_key','',array('class' => 'form-control','id' => 'search-user-logs', 'placeholder' => 'Search By Route Code or Route Name'))}}
							    </div>
							  </div>
							</form>
						</div>
						<div class="col-md-3 search-btn-container">
								{{Form::submit('Search',array('class' => 'btn btn-primary'))}}
								{{Form::close()}}
						</div>
					</div>
				</div>
		</div>

		<div class="row">
		
			<div class="col-md-7">
				<table class="responsive">
				  <thead>
				    <tr>
				      <th>#</th>
				      <th>Route Code</th>
				      <th>Route Name</th>
				      <th>District</th>
				      <th>Edit</th>
				    </tr>
				  </thead>
				  <tbody>
				  @foreach($routes as $route)
				    <tr>
				      <td>{{$route->id}}</td>
				      <td>{{$route->route_code}}</td>
				      <td>{{$route->route_name}}</td>
				      <td>{{$route->location()->first()->location_name}}</td>
				      <td>{{HTML::link('admin/routes/' . $route->id . '/edit', 'Edit', array('style' => 'color:green'))}}</td>
				    </tr>
				   @endforeach
				  </tbody>
				</table>
				
				{{ $routes->appends(array('search_key' => $search_key))->links() }}
				</div>
				<div class="col-md-5">
					{{Form::open(array('array' => 'admin/routes'))}}
					<div class="form-group">
						<h6>Add New Route	</h6>
						<div class="col-md-8">
							<h6>Route Code</h6>
							{{Form::text('route_code','',array('class' => 'form-control'))}}
							<div class="error">{{$errors->first('route_code')}}</div>
						</div>

						<div class="col-md-8">
							<h6>Route Name </h6>
							{{Form::text('route_name','',array('class' => 'form-control'))}}
							<div class="error">{{$errors->first('route_name')}}</div>
						</div>
						<div class="col-md-8">
							<h6>Location</h6>
							{{Form::select('location_id',$locations, array('class' => 'form-control'))}}
							
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8">
						{{Form::submit('Add Route',array('class' => 'btn btn-primary'))}}
						</div>
						{{Form::close()}}
					</div>
				</div>
			</div>
	</div>
@stop