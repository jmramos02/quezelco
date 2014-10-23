@extends('cad.template')
@section('head')
	{{HTML::style("stylesheets/billing.css")}}
@stop
@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Billing/Billing History</h2>
			</div>
		</div>

		<div class="row">
				<div class="col-md-7 options-left">
					{{Form::open(array('url' => 'cad/billing/search', 'method' => 'get'))}}
						<div class="form-group">
							<div class="col-md-8">
								{{Form::label('searchKey','Search:', array('placeholder' => 'Search by OEBR'))}}
								{{Form::text('searchKey')}}
								<input class="btn btn-primary" type="submit" value="Search">
							</div>
						</div>
					{{Form::close()}}
				</div>
		</div>

		<div class="row">
			<div class="col-md-12">
					<div class="table-responsive">
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>OEBR Number</th>
					      <th>Account Number</th>
					      <th>Name</th>
					      <th>Due Date</th>
					      <th>Payment Status</th>
					      <th>Print Billing Statement</th>
					    </tr>
					  </thead>
					  <tbody>
					    @foreach($bills as $bill)
							<tr>
								<td>{{$bill->id}}</td>
								<td>{{$bill->oebr_number}}</td>
								<td>{{$bill->account_number}}</td>
								<td>{{$bill->last_name}} , {{$bill->first_name}}</td>
								<td>{{date('F d, Y', strtotime($bill->due_date))}}</td>
								@if($bill->payment_status == 0)
									<td>Not Yet Paid</td>
								@elseif($bill->payment_status == 1)
									<td>Paid</td>
								@elseif($bill->payment_status == 2)
									<td>For Penalty</td>
								@elseif($bill->payment_status == 3)
									<td>For Disconnection</td>
								@endif
								<td>{{HTML::link('cad/print-billing-statement/' . $bill->account()->first()->id, 'Print', array('style' => 'color:green'))}}</td>
							</tr>
					    @endforeach
					  </tbody>
					</table>
					{{ $bills->appends(array('search_key' => $search_key))->links() }}
				</div>
				
			</div>
		</div>

	</div>
@stop