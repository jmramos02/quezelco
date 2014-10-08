@extends('admin.template')
@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Add Location to User Account "{{$user->username}}"</h2>
			</div>
			<div class="col-md-12 column">
				<h6>Note: Only Area Managers can have multiple locations!</h6>
			</div>
		</div>
		<div class="row">
		</div>
		<div class="row">
			<div class="col-md-12 column">
				{{Form::open(array('url' => 'admin/add-location/' . $user->id))}}
					{{Form::label('location','Location/Designation')}}
					{{Form::select('location',$locations)}}
					<div class="large-5 columns options-right">
						{{Form::submit('Add to Location',array('class' => 'tiny button add-customer'))}}
						{{HTML::link('/admin/user-maintenance','Cancel', array('class'=>'cancel-button'))}}
					</div>
				{{Form::close()}}
			</div>
		</div>
	</div>	
@stop