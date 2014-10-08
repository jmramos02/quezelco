@extends('admin.template')

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Edit Location</h2>
			</div>
		</div>
		<div class="row">
		</div>
		<div class="row">
			{{Form::model($location,array('url' => 'admin/location/' . $location->id, 'method' => 'put'))}}
					{{Form::label('district','District Name')}}
					{{Form::text('district')}}
					<div class="error">{{$errors->first('district')}}</div>

					{{Form::label('location_name','Location Name')}}
					{{Form::text('location_name')}}
					<div class="error">{{$errors->first('location_name')}}</div>

					{{Form::submit('Save',array('class' => 'btn btn-primary'))}}
					{{HTML::link('/admin/location','Cancel', array('class'=>'btn btn-primary cancel-button-primary'))}}
			{{Form::close()}}
		</div>
	</div>	
@stop