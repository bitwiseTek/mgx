@extends('templates.master')

@section('page_title')
	Register
@stop

@section('content')

<div class="container main_content">
	<div class="row">
		<div class="col-md-3 hidden-sm hidden-xs"></div>
	    <div class="col-md-6">
			<h1 style="text-align:center; font-size:3em" class="h1_title">Register to the AWESOME experience!</h1>
			<br>
			{{ Form::open(array('url' => '/register', 'method'=>'post','autocomplete' => 'off','role'=>'form')) }}
			<div class="form-group">
						{{ Form::label('username', 'UserName:',array('class'=>'label')) }}
						{{ Form::text('username','',array('placeholder'=>'Username','class'=>'form-control input-lg')) }}
						{{ $errors->first('username') }}
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('last_name', 'Last Name:',array('class'=>'label')) }}
						{{ Form::text('last_name','',array('placeholder'=>'Enter Last Name','class'=>'form-control input-lg')) }}
						{{ $errors->first('last_name') }}
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('first_name', 'First Name:',array('class'=>'label')) }}
						{{ Form::text('first_name','',array('placeholder'=>'Enter First Name','class'=>'form-control input-lg')) }}
						{{ $errors->first('first_name') }}
					</div>
				</div>
			</div>
			
			<div class="form-group">
						{{ Form::label('phone_no', 'Mobile:',array('class'=>'label')) }}
						{{ Form::text('phone_no','',array('placeholder'=>'phone number','class'=>'form-control input-lg')) }}
						{{ $errors->first('phone_no') }}
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('email', 'Email:',array('class'=>'label')) }}
						{{ Form::text('email','',array('placeholder'=>'example@email.com','class'=>'form-control input-lg')) }}
						{{ $errors->first('email') }}
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('email_confirmation', 'Confirm Email:',array('class'=>'label')) }}
						{{ Form::text('email_confirmation','',array('placeholder'=>'example@email.com','class'=>'form-control input-lg')) }}
						{{ $errors->first('email_confirmation') }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('state', 'State:',array('class'=>'label')) }}
						{{ Form::text('state','',array('placeholder'=>'State','class'=>'form-control input-lg')) }}
						{{ $errors->first('state') }}
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('country', 'Country:',array('class'=>'label')) }}
						{{ Form::text('country','',array('placeholder'=>'Country','class'=>'form-control input-lg')) }}
						{{ $errors->first('country') }}
					</div>
				</div>
			</div>

			<div class="form-group">
				{{ Form::label('address', 'Address:',array('class'=>'label')) }}
				{{ Form::text('address','',array('placeholder'=>'House Address','class'=>'form-control input-lg')) }}
				{{ $errors->first('address') }}
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('dob', 'Date of Birth:',array('class'=>'label')) }}
						{{ Form::text('dob','',array('placeholder'=>'Date of Birth','class'=>'form-control input-lg', 'id'=>'dob')) }}
						{{ $errors->first('dob') }}
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('zip_code', 'Zip-Code:',array('class'=>'label')) }}
						{{ Form::text('zip_code','',array('placeholder'=>'Zip Code','class'=>'form-control input-lg')) }}
						{{ $errors->first('zip_code') }}
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('password', 'Password:',array('class'=>'label')) }}
						{{ Form::password('password',array('placeholder'=>'Password','class'=>'form-control input-lg')) }}
						{{ $errors->first('password') }}
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="form-group">
						{{ Form::label('password_confirmation', 'Retype Password:',array('class'=>'label')) }}
						{{ Form::password('password_confirmation',array('placeholder'=>'Confirm Password','class'=>'form-control input-lg')) }}
						{{ $errors->first('password_confirmation') }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					 By registering, you agree to the <a class="label label-success" href="/terms-and-conditions">terms and conditions</a> of Maple Gold Exchange.
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					{{ Form::submit('Register',array('class'=>'btn btn-blue btn-block btn-small')) }}
				</div>
			</div>
			{{ Form::close() }}
			<hr class="divider">
		</div>

		<div class="col-md-5 hidden-sm hidden-xs">


		</div>
	</div>

</div>
@stop
