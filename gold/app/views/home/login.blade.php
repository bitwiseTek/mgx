@extends('templates.master')

@section('page_title')
	Login 
@stop

@section('content')

<div class="container main_content">
	<div class="row">
		<div class="col-md-4 hidden-sm hidden-xs"></div>
	    <div class="col-md-4">
			<h1 style="text-align:center; font-size:3em" class="h1_title">Login to make that EXCHANGE!</h1>
			<br>
			{{ Form::open(array('url' => '/login', 'method'=>'post','role'=>'form')) }}
				<div class="form-group">
					{{ Form::label('username', 'UserName:',array('class'=>'label')) }}
					{{ Form::text('username','',array('placeholder'=>'Enter your username','class'=>'form-control input-lg')) }}
					{{ $errors->first('username') }}
				</div>
			
				<div class="form-group">
					{{ Form::label('password', 'Password:',array('class'=>'label')) }}
					{{ Form::password('password',array('placeholder'=>'Enter your password','class'=>'form-control input-lg')) }}
					{{ $errors->first('password') }}
				</div>
			
			<div class="row">
				<div class="col-md-3">
					{{ Form::submit('Login',array('class'=>'btn btn-blue btn-block btn-small')) }}
				</div>
				<div class="col-md-9">
					@if(Session::get('login_message'))
							{{Session::get('login_message')}}
					@endif
				</div>
			</div>
			{{ Form::close() }}
			<hr class="divider" />
			<div class="pull-right" style="margin-top:10px;"><a class="label label-success" href="/login/password-recovery">Recover Forgotten Password.</a></div>
		</div>
		<div class="col-md-4 hidden-sm hidden-xs"></div>
	</div>
</div>
@stop