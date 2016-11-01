@extends('templates.master')

@section('page_title')
	View Bank
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<h3>Edit eCurrency</h3>
			<a class="btn btn-green pull-right" href="/admin/currencies">Back</a>
			<hr class="divider"/>
			{{ Form::open(array('url' => '/admin/bank-accounts/edit/'.$data->id, 'method'=>'post','role'=>'form')) }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('bank_name', 'Bank Name :') }}
							{{ Form::text('bank_name', $data->bank_name, array('placeholder'=>'Enter bank name','class'=>'form-control input-lg')) }}
							{{ $errors->first('bank_name') }}
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('status', 'Status :') }}
							{{ Form::select('status', array('enabled'=>'Enabled','disabled'=>'Disabled'), $data->status, ['class'=>'form-control input-lg']) }}
							{{ $errors->first('status') }}
						</div>
					</div>
					
				</div>
				<div class="row">
					<div class="col-md-3">
						<input type="submit" class="btn btn-sm btn-primary" value="Edit" />
					</div>
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@stop