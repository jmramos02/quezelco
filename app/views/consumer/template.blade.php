  <!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>QUEZELCO | Electronic Cooperative, INC</title>
	{{HTML::style('bower_components/bootstrap-sass/dist/css/bootstrap.min.css')}}
	{{HTML::style("libs/foundation/css/normalize.css")}}
	{{HTML::style('http://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css')}}
	{{HTML::style("libs/foundation/css/foundation.css")}}
	{{HTML::style('stylesheets/datetimepicker.css')}}
	{{HTML::style("stylesheets/globals.css")}}
	{{HTML::style("libs/zurb-responsive-tables/responsive-tables.css")}}
	{{HTML::style('http://fonts.googleapis.com/css?family=Roboto+Condensed')}}
    {{HTML::style("http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css")}}
	<!--If developer wants to add files-->
	@yield('head')
</head>
<body>
	
	<!-- Navigation -->
	<nav class="navbar navbar-default" role="navigation">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">QUEZELCO</a>
	    </div>

		  <div class="collapse navbar-collapse" id="navbar-collapse">
		  	
		  	 <!-- Left Nav Section -->
		    <ul class="nav navbar-nav">
		      <li><a href="{{URL::to('consumer/home')}}">Home</a></li>
		      <li><a href="{{URL::to('consumer/billing-history')}}">View Billing History</a></li>
		      <li><a href="{{URL::to('consumer/enroll')}}">Enroll for SMS</a></li>
		    </ul>

		    <!-- Right Nav Section -->
		    <ul class="nav navbar-nav navbar-right">
		      <li><a href="#">My Account</a></li>
		      <li><a href="{{URL::to('consumer/logout')}}">Logout</a></li>
		    </ul>
		  </div>
	</nav>
	<!-- End of Navigation -->
	<!-- Main Content -->
	@yield('content')
	<!-- End of Main Content -->
	{{HTML::script('libs/foundation/js/vendor/jquery.js')}}
	{{HTML::script("libs/foundation/js/vendor/modernizr.js")}}
	{{HTML::script('libs/foundation/js/foundation.min.js')}}
  	{{HTML::script("bower_components/bootstrap-sass/dist/js/bootstrap.min.js")}}
  	{{HTML::script('http://code.jquery.com/ui/1.11.1/jquery-ui.js')}}
  	<script>
    	$(document).foundation();

    	$(document).ready(function(){
    		$(".datepicker").datepicker();
    	});	
  	</script>
</body>
</html>
