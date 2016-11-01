<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<title>Maple Gold Exchange Transaction Page</title>
	</head>
		<body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
			<div style="padding:10px; background:#333; font-size:19px; color:#CCC;">
			 Maple Gold Exchange Transaction Page
			</div>

			<div style="padding:24px; font-size:13px;">
				<span style="font-weight:bold">{{$last_name}} {{$first_name}}</span>, 
					Congratulations!! Your transaction was successful, observe transaction details below;
				<p>
					<div>
						<span style="font-weight:bold">Transaction Reference Number: </span>{{$ref_no}}
					</div>
					<div>
						<span style="font-weight:bold">Amount: </span>N{{number_format($amount, 2)}}
					</div>
				</p>

				<p>
					<div>
						<span style="font-weight:bold">So what next?</span>
					</div>
					<div>
						Start by learning the entire process step-by-step <a href="http://www.maplexhange.com/how-it-works">Maple Guide.</a>
					</div>
				</p>
			</div>

			<p>Maple Gold Exchange powered by Bitwise Tech.</p>
			<p><span style="font-weight:bold">Maple Team.</span></p>
	</body>
</html>