@extends('templates.master')

@section('page_title')
	New Bank
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<h3>New Bank</h3>
			<a class="btn btn-green pull-right" href="/admin/currencies">Back</a>
			<hr class="divider"/>
			{{ Form::open(array('url' => '/admin/bank-accounts/add', 'method'=>'post','role'=>'form')) }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('name', 'Bank Name :') }}
							{{ Form::text('bank_name','',array('placeholder'=>'Enter bank name','class'=>'form-control input-lg')) }}
							{{ $errors->first('bank_name') }}
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('status', 'Status :') }}
							{{ Form::select('status', array( 'enabled'=>'Enabled','disabled'=>'Disabled'),'enabled', ['class'=>'form-control input-lg']) }}
							{{ $errors->first('status') }}
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-3">
						{{ Form::submit('Create',array('class'=>'btn btn-blue btn-block btn-small')) }}
					</div>
					<div class="col-md-9"></div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop