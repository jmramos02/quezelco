@extends('admin.template')
@section('head')
	{{HTML::style("stylesheets/billing.css")}}
@stop
@section('content')
	<div class="container">
		<div class="row billing-title">
			<div class="col-md-12 column">
				<h2>Monitoring</h2>
			</div>
		</div>

		<div class="row">
				<div class="col-md-7 options-left">
					<form role="form" action="">
						<div class="form-group">
							<div class="col-md-3">
								<label for="month"><h6>Month:</h6></label>
								<select value="Aug">
									<option value="jan">January</option>
									<option value="feb">February</option>
									<option value="mar">March</option>
									<option value="apr">April</option>
									<option value="may">May</option>
									<option value="jun">June</option>
									<option value="jul">July</option>
									<option value="aug">August</option>
									<option value="sep">September</option>
									<option value="oct">October</option>
									<option value="nov">November</option>
									<option value="dec">December</option>
								</select>
							</div>
							
							<div class="col-md-3">
								<label for="year"><h6>Year:</h6></label>
								<select value="2014">
									<option value="2011">2011</option>
									<option value="2012">2012</option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
								</select>
							</div>

							<div class="col-md-3">
								<label for="area"><h6>Area:</h6></label>
								<select value="All">
									<option>Area 1</option>
									<option>Area 2</option>
									<option>Area 3</option>
									<option>Area 4</option>
									<option>Area 5</option>
								</select>
							</div>

							<div class="col-md-3 search-btn-container">
								<input class="btn btn-primary" type="submit" value="Search">
							</div>
							
						</div>
					</form>
				</div>
				<!--<div class="col-md-5 options-right">
					<button class="btn btn-primary"><a href="add-customer.html"><i class="fa fa-plus"></i> Add Customer</a></button>
				</div>
				 <div class="large-6 columns options-right">
					<button class="button tiny">Add Customer</button>
					<label>Page:</label>
					<select name="page" id="page">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
					<button class="button tiny">Prev Page</button>
					<button class="button tiny">Next Page</button>
				</div>-->

		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped">
					  <thead>
					    <tr>
					      <th>#</th>
					      <th>Meter ID</th>
					      <th>Area</th>
					      <th>Account ID</th>
					      <th>Name</th>
					      <th>Previous</th>
					      <th>Present</th>
					      <th>Others</th>
					      <th>Others</th>
					    </tr>
					  </thead>
					  <tbody>
					    <tr>
					      <td>Content Goes Here</td>
					      <td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
					      <td>Content Goes Here</td>
					      <td>Content Goes Here</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					    </tr>

					    <tr>
					      <td>Content Goes Here</td>
					      <td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
					      <td>Content Goes Here</td>
					      <td>Content Goes Here</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					    </tr>
					    <tr>
					      <td>Content Goes Here</td>
					      <td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
					      <td>Content Goes Here</td>
					      <td>Content Goes Here</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					      <td>Sample</td>
					    </tr>
					  </tbody>
					</table>
				</div>
				
			</div>
		</div>

	</div>
@stop