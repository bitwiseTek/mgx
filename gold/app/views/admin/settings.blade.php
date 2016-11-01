@extends('templates.master')

@section('page_title')
	Account settings
@stop

@section('content')	
	<div class="container main_content">
		<div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
				<div class="row">
					<div class="col-md-8">
						@if(Session::get('editInfo_message'))
							<div>{{Session::get('editInfo_message')}}</div>
						@endif
						<h3>Personal Information</h3>
						<hr class="divider"/>
						{{ Form::open(array('url' => '/admin/settings/info', 'method'=>'post','role'=>'form')) }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('last_name', 'LastName:') }}
									{{ Form::text('last_name',$data['info']->last_name,array('placeholder'=>'Enter your Last Name','class'=>'form-control input-lg')) }}
									{{ $errors->first('last_name') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('first_name', 'FirstName') }}
									{{ Form::text('first_name',$data['info']->first_name,array('placeholder'=>'Enter your First Name','class'=>'form-control input-lg')) }}
									{{ $errors->first('first_name') }}
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('email', 'Email:') }}
									{{ Form::text('email',$data['info']->email,array('class'=>'form-control input-lg','disabled'=>'disabled')) }}
									{{ $errors->first('email') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('phone_no', 'Phone') }}
									{{ Form::text('phone_no',$data['info']->phone_no,array('placeholder'=>'Enter your mobile Number','class'=>'form-control input-lg')) }}
									{{ $errors->first('phone_no') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9"></div>
							<div class="col-md-3">
								{{ Form::submit('Update',array('class'=>'btn btn-blue btn-block btn-small','name'=>'edit_info')) }}
							</div>
						</div>
						{{ Form::close() }}
					</div>
				</div>

				<br><br>

				<div class="row">
					@if(Session::get('editPassword_message'))
						<div>{{Session::get('editPassword_message')}}</div>
					@endif
					<div class="col-md-8">
						<h3>Password Settings</h3>
						<hr class="divider"/>
						{{ Form::open(array('url' => '/admin/settings/password', 'method'=>'post','role'=>'form')) }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('old_password', 'Current Password:') }}
									{{ Form::password('old_password','',array('placeholder'=>'Enter Current password','class'=>'form-control input-lg')) }}
									{{ $errors->first('old_password') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{{ Form::label('new_password', 'New Password:') }}
									{{ Form::password('new_password','',array('placeholder'=>'Enter New Password','class'=>'form-control input-lg')) }}
									{{ $errors->first('new_password') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-9"></div>
							<div class="col-md-3">
								{{ Form::submit('Update',array('class'=>'btn btn-blue btn-block btn-small')) }}
							</div>
						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
@stop