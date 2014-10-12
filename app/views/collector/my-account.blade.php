@extends('cad.template')
@section('head')
	{{HTML::style("stylesheets/my-account.css")}}
@stop
@section('content')
	<div class="container">
		<div class="col-md-12 my-account-title">
				<h2>My Account</h2>
		</div>
			<div class="col-md-12">
				<div class="row">
					{{Form::open(['action' => 'CollectorController@updatePassword'])}}

							<div class="error">{{$errors->first('current_password')}}</div>
							{{Form::label('current_password','Current Password')}}
							{{Form::text('current_password',Input::old('current_password'))}}
							
							<div class="error">{{$errors->first('new_password')}}</div>
							{{Form::label('new_password','New Password')}}
							{{Form::text('new_password',Input::old('new_password'))}}

							<div class="error">{{$errors->first('repeat_new_password')}}</div>
							{{Form::label('repeat_new_password','Repeat New Password')}}
							{{Form::text('repeat_new_password',Input::old('repeat_new_password'))}}
							
								{{Form::submit('Reset Password',array('class' => 'tiny button reset-password'))}}
							
					{{Form::close()}}
				</div>
			</div>
		</div>
@stop