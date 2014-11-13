@extends('admin.template')
@section('head')
	{{HTML::style("stylesheets/my-account.css")}}
@stop
@section('content')
	<div class="container">
		<div class="col-md-12 my-account-title">
		<h2>Billing History</h2>
		</div>
			<div class="col-md-12">
			<div class="row">
			<div class="col-md-12">
					<div class="table-responsive">
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>OEBR Number</th>
					      <th>Account Number</th>
					      <th>Due Date</th>
					      <th>Payment Status</th>
					      <th>Due</th>
					    </tr>
					  </thead>
					  <tbody>
					    @foreach($bills as $bill)
							<tr>
								<td>{{$bill->id}}</td>
								<td>{{$bill->account->first()->oebr_number}}</td>
								<td>{{$bill->account->first()->account_number}}</td>
								<td>{{$bill->due_date}}</td>
								@if($bill->payment_status == 0)
									<td>Not Yet Paid</td>
								@elseif($bill->payment_status == 1)
									<td>Paid</td>
								@elseif($bill->payment_status == 2)
									<td>For Penalty</td>
								@elseif($bill->payment_status == 3)
									<td>For Disconnection</td>
								@endif
								<td>{{($bill->payment()->first()->payment) - ($bill->payment()->first()->change)}}</td>
							</tr>
					    @endforeach
					  </tbody>
					</table>
					{{ $bills->links() }}
				</div>
				
			</div>
		</div>
			</div>
		</div>
@stop