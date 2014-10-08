@extends('admin.template')

@section('head')
	{{HTML::style('stylesheets/user-maintenance.css')}}
@stop  

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>View Routes</h2>
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
			{{HTML::link('/admin/location','Back', array('class'=>'btn btn-primary cancel-button-primary margin-bot5'))}}
			<table class="responsive">
			  <thead>
			    <tr>
			      <th>#</th>
			      <th>Route Code</th>
			      <th>Route Name</th>
			    </tr>
			  </thead>
			  <tbody>
			  @foreach($routes as $route)
			    <tr>
			      <td>{{$route->id}}</td>
			      <td>{{$route->route_code}}</td>
			      <td>{{$route->route_name}}</td>
			    </tr>
			   @endforeach
			  </tbody>
			</table>
			{{$routes->links()}}
		</div>
	</div>
@stop