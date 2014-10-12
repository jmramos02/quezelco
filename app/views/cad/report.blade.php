@extends('cad.template')
@section('head')
	{{HTML::style('stylesheets/reports.css')}}
@stop
@section('content')
	<div class="row">
		<div class="large-12 column">
			<h2>Reports</h2>
		</div>
	</div>		
		
		<div class="row report-container">
			<div class="large-12 columns report-name">
				{{HTML::link('admin/reports/user-list','User List',array('class' => 'small a'))}}
			</div>

			<div class="large-12 columns report-name">
				{{HTML::link('admin/reports/location-list','Location List',array('class' => 'small a'))}}
			</div>

			<div class="large-12 columns report-name">
				{{HTML::link('admin/reports/route-list',"List of Brgy's",array('class' => 'small a'))}}
			</div>

			<div class="large-12 columns report-name">
				{{HTML::link('admin/reports/consumer-list', 'Consumer List', array('class' => 'small a'))}}
			</div>

		</div>
@stop