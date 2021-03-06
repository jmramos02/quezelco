@extends('admin.template')
@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Add New User</h2>
			</div>
		</div>
		<div class="row">
		</div>
		<div class="row">
			{{Form::open(array('url' => 'admin/add-user'))}}
				{{Form::label('role','Role')}}
				{{Form::select('role',$roles)}}
				<div class="error">{{$errors->first('username')}}</div>
				{{Form::label('username','Username')}}
				{{Form::text('username',Input::old('username'))}}
				<div class="error">{{$errors->first('password')}}</div>
				{{Form::label('password','Password')}}
				{{Form::password('password')}}
				{{Form::label('password_confirmation','Confirm Password')}}
				{{Form::password('password_confirmation')}}
				<div class="error">{{$errors->first('first_name')}}</div>
				{{Form::label('first_name','First Name')}}
				{{Form::text('first_name',Input::old('first_name'))}}
				{{Form::label('last_name','Last Name')}}
				{{Form::text('last_name',Input::old('last_name'))}}
				<div class="error">{{$errors->first('last_name')}}</div>
				{{Form::label('address','Address')}}
				{{Form::text('address',Input::old('address'))}}
				<div class="error">{{$errors->first('address')}}</div>
				{{Form::label('contact_number','Contact Number')}}
				{{Form::text('contact_number',Input::old('contact_number'))}}
				{{Form::label('location','Location/Designation')}}
				{{Form::select('location',$locations)}}
				<div class="large-5 columns options-right">
					{{Form::submit('Add User',array('class' => 'tiny button add-customer'))}}
					{{HTML::link('/admin/user-maintenance','Cancel', array('class'=>'cancel-button'))}}
				</div>
			{{Form::close()}}
		</div>
	</div>	
@stop