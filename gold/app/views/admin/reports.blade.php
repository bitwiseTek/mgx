@extends('templates.master')

@section('page_title')
	System Summary
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<h3>System Reports</h3>
			<hr class="divider"/>
			
		</div>
	</div>
</div>
@stop