<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="en" >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QUEZELCO | Electronic Cooperative, INC</title>

  {{HTML::style('libs/foundation/css/normalize.css')}}
  {{HTML::style('libs/foundation/css/foundation.css')}}
  {{HTML::style('stylesheets/login.css')}}
  {{HTML::style('libs/zurb-responsive-tables/responsive-tables.css')}}
  {{HTML::style('http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css')}}
  {{HTML::style('http://fonts.googleapis.com/css?family=Roboto+Condensed')}}
  {{HTML::style("stylesheets/globals.css")}}
  {{HTML::script('libs/foundation/js/vendor/modernizr.js')}}

</head>

<body>
	<!-- Main Content -->
    <div class="row">
      <h3 class="login-title">Forgot Password</h3>
    <div class="large-6 small-centered column login-container">
      <div class="logo-container">
        {{HTML::image('images/logo.png','',array('class'=>'logo'))}}
      </div>
        {{Form::open(array('url' => '/forgot-password','method' => 'post'))}}
          {{Form::label('username','Username')}}
          {{Form::text('username')}}
          {{Form::label('first_name','First Name')}}
          {{Form::text('first_name')}}
          {{Form::label('last_name','Last Name')}}
          {{Form::text('last_name')}}
          {{Form::label('cell_no','Cell No. (your new password will be sent here)')}}
          {{Form::text('cell_no','',array('maxlength' => '10'))}}
          {{Form::submit('Submit',array('class'=>'button'))}}
          {{HTML::link('/index','Back',array('class' => 'button'))}}
        {{Form::close()}}
        <!--Laravel Errors/Notifications-->
        @if(isset($error_message))
          <h6 style = "color:red">{{$error_message}}</h6>
        @endif

        @if(isset($logout_message))
          <h6 style = "color:blue">{{$logout_message}}</h6>
        @endif
      </div>

    </div>
   

	<!-- End of Main Content -->

  {{HTML::script('libs/foundation/js/vendor/jquery.js')}}
  {{HTML::script('libs/foundation/js/foundation.min.js')}}
  {{HTML::script('libs/zurb-responsive-tables/responsive-tables.js')}}
  <script>
    $(document).foundation();
  </script>
</body>
</html>