<!DOCTYPE html>
<html>
<head>
	<title>@yield('page_title')</title>
	<link rel="icon" href="../../favicon.ico">  
	<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/tello/fontello.css" rel="stylesheet">
    <link href="/assets/css/site.css" rel="stylesheet">
	
</head>
<body>
	<div class="container">
		<div  style="margin-left:40%">
			<div style="margin-top:30%">
				<a href="/"><img style="width:60px;height:30px" src="/assets/images/lop.png" class="logo" alt="edey"></a>
			</div>
			<div style="margin-left:2%" id="content">			
				@yield('content')
			</div>
		</div>
	</div>
</body>
</html>