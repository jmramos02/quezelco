@extends('admin.template')

@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Edit User</h2>
			</div>
		</div>
		<div class="row">
		</div>
		<div class="row">
			{{Form::model($user,array('url' => 'admin/update-user/' . $user->id, 'method' => 'put'))}}
					<div class="error">{{$errors->first('first_name')}}</div>
					{{Form::label('first_name','First Name')}}
					{{Form::text('first_name')}}
					{{Form::label('last_name','Last Name')}}
					{{Form::text('last_name')}}
					<div class="error">{{$errors->first('last_name')}}</div>
					{{Form::label('address','Address')}}
					{{Form::text('address')}}
					<div class="error">{{$errors->first('address')}}</div>
					{{Form::label('contact_number','Contact Number')}}
					{{Form::text('contact_number')}}
					{{Form::label('role','Role')}}
					{{Form::select('role',$roles)}}
					{{Form::label('location','Location/Designation')}}
					{{Form::select('location',$locations)}}
					<div class="large-5 columns options-right">
						{{Form::submit('Update User',array('class' => 'tiny button add-customer'))}}
						{{HTML::link('/admin/user-maintenance','Cancel', array('class'=>'cancel-button'))}}
					</div>
			{{Form::close()}}
		</div>
	</div>	
@stop