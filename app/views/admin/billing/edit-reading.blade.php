@extends('admin.template')
@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Update Reading</h2>
			</div>
		</div>
		<div class="row">
		</div>
		<div class="row">
			<div class="dtBox">
			{{Form::model($bill,array('url' => 'admin/update-billing/' . $bill->id, 'method' => 'GET'))}}

					<div class="error">{{$errors->first('current_reading')}}</div>
					{{Form::label('update_reading','Update Reading')}}
					{{Form::text('current_reading')}}
					
					<div class="error">{{$errors->first('start_date')}}</div>
					{{Form::label('start_date','Reading From: ')}}
					{{Form::text('start_date', Input::old('start_date'),array('class' => 'datepicker'))}}
					
					<div class="error">{{$errors->first('end_date')}}</div>
					{{Form::label('end_date','Reading To:')}}
					{{Form::text('end_date', Input::old('end_date'),array('class' => 'datepicker'))}}
				
					<div class="large-5 columns options-right">
						{{Form::submit('Update Reading',array('class' => 'tiny button add-customer'))}}
						{{HTML::link('/admin/billing','Cancel', array('class'=>'cancel-button'))}}
					</div>
			{{Form::close()}}
			</div>
		</div>
	</div>	
@stop