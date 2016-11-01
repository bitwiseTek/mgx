@extends('templates.master')

@section('page_title')
	Oya your password don reset
@stop

@section('content')
	@include('templates.include_search')
		<div class="container main_content">
			<div class="row">
		   		 <div class="col-md-6 ">
				   	@if(Session::get('recovery_message'))
				   		<h3>Notice</h3>
				   		 <div>{{Session::get('recovery_message')}}</div>
				   	@endif
				 </div>
			</div>
		</div>
@stop