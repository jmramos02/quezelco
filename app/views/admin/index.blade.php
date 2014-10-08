@extends('admin.template')
@section('head')
	{{HTML::style("stylesheets/index.css")}}
@stop

@section('content')
		<div class="container index-container">
			<div class="col-md-8">
					<h3>User Logs</h3>
					{{Form::open(array('url' => 'admin/home'))}}
					<div class="col-md-7 options-left">
					<form role="form" action="">
						<div class="form-group">
							<div class="col-md-9">
								<form role="form">
								  <div class="form-group">
								    <div class="input-group">
								    	<div class="input-group-addon"><i class="fa fa-search"></i></div>
								    	{{Form::text('search_key','',array('class' => 'form-control','id' => 'search-user-logs', 'placeholder' => 'Search'))}}
								    </div>
								  </div>
								</form>
							</div>
							<div class="col-md-3 search-btn-container">
									{{Form::submit('Search',array('class' => 'btn btn-primary'))}}
							</div>
						</div>
					</div>
					{{Form::close()}}
						<div class="table-responsive">
							<table class="table table-striped">
							<thead>
								<th>Log Date and Time</th>						
								<th>Last Name</th>						
								<th>First Name</th>
								<th>Username</th>
								<th>Action</th>
							</thead>
							<tbody>
								@foreach($logs as $log)
									<tr>
										<td>{{$log->created_at}}</td>
										<td>{{$log->user()->first()->last_name}}</td>
										<td>{{$log->user()->first()->first_name}}</td>
										<td>{{$log->user()->first()->username}}</td>
										@if($log->status == 1)
											<td>Logged In</td>
										@else
											<td>Logged Out</td>		
										@endif
										
									</tr>
								@endforeach 	
							</tbody>
						</table>
					</div>
					{{$logs->links()}}
			</div>
					
			
			
			<div class="col-md-4">
				<h3>Notifications</h3>
				<div class="notif-container">
					<article>
						<h6>sysadmin3 has created a new customer.</h6>
						<p>3 hours ago</p>
					</article>
					<article>
						<h6>sysadmin3 has approved 3 new OEBRs.</h6>
						<p>5 hours ago</p>
					</article>
					<article>
						<h6>sysadmin3 has deleted a file.</h6>
						<p>6 hours ago</p>
					</article>
					<article>
						<h6>sysadmin3 has deleted a file.</h6>
						<p>7 hours ago</p>
					</article>
					<article>
						<h6>sysadmin3 has deleted a file.</h6>
						<p>7 hours ago</p>
					</article>

				</div>
			</div>
		</div>
		</div>
@stop