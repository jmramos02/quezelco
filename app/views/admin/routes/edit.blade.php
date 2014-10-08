@extends('admin.template')

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Edit Route</h2>
			</div>
		</div>
		<div class="row">
		</div>
		<div class="row">
			{{Form::model($route,array('url' => 'admin/routes/' . $route->id, 'method' => 'put'))}}
					{{Form::label('route_code','Route Code')}}
					{{Form::text('route_code')}}
					<div class="error">{{$errors->first('route_code')}}</div>

					{{Form::label('route_name','Route Name')}}
					{{Form::text('route_name')}}
					<div class="error">{{$errors->first('route_name')}}</div>

					{{Form::label('location_id','Location')}}
					{{Form::select('location_id', $locations)}}

					{{Form::submit('Save',array('class' => 'btn btn-primary'))}}
					{{HTML::link('/admin/routes','Cancel', array('class'=>'btn btn-primary cancel-button-primary'))}}
			{{Form::close()}}
		</div>
	</div>	
@stop