<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-dns-prefetch-control" content="on"></meta>
    <meta name="author" content="Bitwise Tech">
    <link rel="shortcut icon" href="/assets/images/logo10.png">
	  <meta name="robots" content="index,follow"></meta>

    <title>MGX : @yield('page_title')</title>
    
    <link rel="icon" href="../../favicon.ico">  
    <link href="/assets/css/bootstrap.css" rel="stylesheet">
    <link href="/assets/css/fontello.css" rel="stylesheet">
    <link href="/assets/css/sitev11.css" rel="stylesheet">
    <link href="/assets/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/assets/css/jquery-ui.theme.min.css" rel="stylesheet">
    <script src="/assets/js/jquery-1.9.min.js"></script>
    <script src="/assets/js/jquery-ui.min.js"></script>
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/sitev4.js"></script>
    <style type="text/css">
      a:link {
  	   text-decoration: none;
      }
      a:visited {
      	text-decoration: none;
      }
      a:hover {
      	text-decoration: none;
      }
      a:active {
      	text-decoration: none;
      }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
          $("#dob").datepicker({
              dateFormat: "yy-mm-dd",
              changeYear: true, 
              showOtherMonths: true,
              selectOtherMonths: true,
              changeMonth: true,
              yearRange: "-100:+10"
          });
        });
    </script>
  </head>
  <body>
    
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="col-md-12" id="top_address">
        <div class="container">
          <div class="pull-right">
            <span>Phone:+2349093770635&nbsp;WhatsApp:+2348140554066&nbsp;e-mail:info@maplexchange.com</span>
            <span>Work hours:8AM-5PM(Mon-Fri),9AM-4PM(Sat),12PM-6PM(Sun)</span>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="/" class="navbar-brand"><img src="/assets/images/logo9.png" class="logo" alt="Gold" width="150" height="55"/></a>
        </div>
        <div class="navbar-collapse collapse pull-right">
        	<ul class="nav navbar-nav ">			       
              <li class="{{(Request::is('how-it-works')) ? 'active': '' }}"><a href="/how-it-works">How It Works</a></li>
              <li class="{{(Request::is('about-us')) ? 'active': '' }}"><a href="/about-us">About Us</a></li>
          </ul>
          @if(Session::get('user_id'))
          	@if(Session::get('account_type')=='user')
               <ul class="nav navbar-nav">
                  <li class="dropdown {{(Request::is('user/*')) ? 'active': '' }}">
                    <a href="/users/dashboard" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user-1"></i> {{Session::get('username')}} <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="/users/summary"><i class="icon-suitcase"></i> &nbsp; Summary</a></li>
                      <li><a href="/users/exchange-currencies"><i class="icon-star-1"></i> &nbsp; Exchange</a></li>
                      <li><a href="/users/transactions"><i class="icon-chat"></i> &nbsp; Transactions</a></li>
                      <li><a href="/users/settings"><i class="icon-cog-alt"></i> &nbsp; Settings</a></li>
                      <li class="divider"></li>
                      <li><a href="/log-out"><i class="icon-logout-1"></i> &nbsp; LogOut</a></li>
                    </ul>
                  </li>
              </ul>
  		      @elseif(Session::get('account_type')=='admin')
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown {{(Request::is('admin/*') || Request::is('admin/')) ? 'active': '' }}">
                  <a href="/admin/summary" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user-1"></i> {{Session::get('username')}} <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/admin/summary"><i class="icon-users"></i> &nbsp; Summary</a></li>
                    <li><a href="/admin/transactions"><i class="icon-chat-1"></i> &nbsp; Transactions</a></li>
                    <li><a href="/admin/users"><i class="icon-road"></i> &nbsp; Users</a></li>
                    <li><a href="/admin/reports"><i class="icon-road"></i> &nbsp; Reports</a></li>
                    <li><a href="/admin/currencies"><i class="icon-road"></i> &nbsp; Configuration</a></li>
                    <li><a href="/admin/settings"><i class="icon-cog-alt"></i> &nbsp; Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="/log-out"><i class="icon-logout-1"></i> &nbsp; Log-Out</a></li>
                  </ul>
                </li>
              </ul>
  		    	  @endif
            @else
             <ul class="nav navbar-nav ">
               <li class="{{(Request::is('login*')) ? 'active': '' }}"><a href="/login" class="">Login</a></li>
               <li class="{{(Request::is('register*')) ? 'active': '' }}"><a href="/register" class="">Register</a></li>
             </ul>
            @endif    
        </div>
    </div>
  </div>
<br>
    <!-- Main Section -->
    <div class="well-bg">
  	<div id="container">
  		@yield('content')
  	</div></div>
 
    <!-- Footer Section -->
    <div class="container">
      <div class="well-lg"><img src="/assets/images/logostrip.jpg" class="img-responsive" width="100%" alt=""/></div></div>
      <div class="well-lg">&nbsp;&nbsp;&nbsp;</div>
      <div class="well-lg">&nbsp;&nbsp;&nbsp;</div>
  <div class="footer">
        <div class="container">
          <span class="left">Maple Gold Exchange. {{date('Y')}}.  Powered by Bitwise Tech</span>
          <span class="pull-right"><a href="/privacy-policy">Privacy Policy</a> &nbsp; &nbsp; <a href="/terms-and-conditions">Terms of Service</a> &nbsp; &nbsp; <a href="/anti-money-policy">Anti-Money Laundering</a></span>
        </div>
    </div>

     <!-- Javascript Includes -->
    
  </body>
</html>