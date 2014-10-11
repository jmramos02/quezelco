@extends('admin.template')
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
					{{Form::open(array('url' => 'admin/my-account'))}}
							{{Form::label('current-password','Current Password')}}
							{{Form::text('current-password',Input::old('current-password'))}}
							
							{{Form::label('new-password','New Password')}}
							{{Form::text('new-password',Input::old('new-password'))}}

							{{Form::label('repeat-new-password','Repeat New Password')}}
							{{Form::text('repeat-new-password',Input::old('repeat-new-password'))}}
							
								{{Form::submit('Reset Password',array('class' => 'tiny button reset-password'))}}
							
					{{Form::close()}}
				</div>
			</div>
		</div>
@stop