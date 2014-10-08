@extends('admin.template')

@section('head')
	{{HTML::style('stylesheets/user-maintenance.css')}}
@stop  

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Location Setup</h2>
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
		{{Form::open(array('url' => 'admin/location/search', 'method' => 'get'))}}
			<div class="col-md-7 options-left">
				<div class="form-group">
						<div class="col-md-9">
							  <div class="form-group">
							    <div class="input-group">
							    	<div class="input-group-addon"><i class="fa fa-search"></i></div>
							    	{{Form::text('search_key','',array('class' => 'form-control','id' => 'search-user-logs', 'placeholder' => 'Search by Locaiton Name'))}}
							    </div>
							    <div class="col-md-3 search-btn-container">
									<BR>
									<!--<div class="btn btn-primary"><a href="{{URL::to('admin/add-user')}}"><i class="fa fa-plus"></i> Add Location</a></div>-->
								</div>
							  </div>
						</div>
						<div class="col-md-3 search-btn-container">
								{{Form::submit('Search',array('class' => 'btn btn-primary'))}}
							{{Form::close()}}
						</div>
					</div>
				<div class="row">
					<table class="responsive">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>District</th>
					      <th>Location Name</th>
					      <th>Edit</th>
					      <th>View Brgy's</th>
					    </tr>
					  </thead>
					  <tbody>
					  @foreach($locations as $location)
					    <tr>
					      <td>{{$location->id}}</td>
					      <td>{{$location->district}}</td>
					      <td>{{$location->location_name}}</td>
					      <td>{{HTML::link('admin/location/' . $location->id . '/edit', 'Edit', array('style' => 'color:green'))}}</td>
					      <td>
							{{HTML::link('admin/location/' . $location->id, 'View Brgys', array('style' => 'color:green'))}}
					      </td>
					    </tr>
					   @endforeach
					  </tbody>
					</table>
					{{ $locations->appends(array('search_key' => $search_key))->links() }}
				</div>
					
				</div>
			<div class="col-md-5 options-left">
					{{Form::open(array('url' => 'admin/location'))}}
					<h6>Add New Location</h6>
					<div class="form-group">
						<div class="col-md-8">
							<h6>District Name</h6>
							{{Form::text('district_name','',array('class' => 'form-control'))}}
							<div class="error">{{$errors->first('district_name')}}</div>
						</div>

						<div class="col-md-8">
							<h6>Location Name </h6>
							{{Form::text('location_name','',array('class' => 'form-control'))}}
							<div class="error">{{$errors->first('location_name')}}</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8">
							{{Form::submit('Add Location',array('class' => 'btn btn-primary'))}}
						</div>
						{{Form::close()}}
					</div>
			</div>
		</div>
	</div>
@stop