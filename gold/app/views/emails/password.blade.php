<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>Password Recovery</title>
	</head>
		<body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
				<div style="padding:10px; background:#333; font-size:19px; color:#CCC;">
					<a href="http://www.edey.biz"><img src="http://www.edey.biz/images/logos/logo.png" width="80" height="73" alt="eDey" style="border:none; float:left;"></a>
					eDey Password Recovery
				</div>
				<div style="padding:24px; font-size:13px;">
					<span style="font-weight:bold">{{ $name}}</span>, you requested to reset your password. Ignore this mail if you never did or click on the link below to reset your password
					<p>Link: <a href="http://www.edey.biz/login/token/check?token={{$token}}&email={{$email}}">http://www.edey.biz/login/token/check?token={{$token}}&email={{$email}}</a></p>
				</div>
				<p><span style="font-weight:bold">eDey Accounts Dept.</span></p>
		</body>
</html>