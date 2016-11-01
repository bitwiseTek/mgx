@extends('templates.master')

@section('page_title')
	How to make excahnge
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-12">
			<h1 style="text-align:center; font-size:3em" class="h1_title">How the Exchange Works</h1>
		</div>
	</div>

	<div style="margin-top:30px;" class="row hiw_steps_con">
		<div class="col-md-4">
			<h1 style="text-align:center; font-size:2.1em;">Step 1</h1>
		</div>
	    <div class="col-md-7 hiw_steps_content">
	    	You login or sign-up, check current exchange rates. Then click on exchange now menu to 
	    	place exchange order.
	    </div>
	</div>

	<div class="row hiw_steps_con">
		<div class="col-md-4">
			<h1 style="text-align:center; font-size:2.1em">Step 2</h1>
		</div>
	    <div class="col-md-7 hiw_steps_content">
	    	Make bank deposit payment and send payment details to us. We verify payment. 
	    </div>
	</div>

	<div class="row hiw_steps_con">
		<div class="col-md-4">
			<h1 style="text-align:center; font-size:2.1em">Step 3</h1>
		</div>
	    <div class="col-md-7 hiw_steps_content">
	    	Your eCurreny account get credited with the equivalent.
	    </div>
	</div>

</div>
@stop