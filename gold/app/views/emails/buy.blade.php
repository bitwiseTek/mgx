<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>eDey Subscription</title>
	</head>
		<body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
			<div style="padding:10px; background:#333; font-size:19px; color:#CCC;">
				<a href="http://www.edey.biz"><img src="http://www.edey.biz/images/logos/logo.png" width="80" height="73" alt="eDey" style="border:none; float:left;"></a>
				eDey Subscription
			</div>
			<div style="padding:24px; font-size:13px;">
				<span style="font-weight:bold">{{$name}}</span>, your business Listing has been activated and is valid from {{date('d-m-Y',strtotime($start))}} to {{date('d-m-Y',strtotime($end))}}. Please click the link below to see it in action.
				<p>Link: <a href="http://www.edey.biz/businesses/view/{{$business_id}}/{{$business_name}}">http://www.edey.biz/businesses/view/{{$business_id}}/{{$business_name}}</a></p>
			</div>

			<p><span style="font-weight:bold">eDey Marketing Dept.</span></p>
		</body>
</html>