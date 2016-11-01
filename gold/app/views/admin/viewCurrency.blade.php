@extends('templates.master')

@section('page_title')
	View Currency
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<h3>Edit eCurrency</h3>
			<a class="btn btn-green pull-right" href="/admin/currencies">Back</a>
			<hr class="divider"/>
			{{ Form::open(array('url' => '/admin/currencies/edit/'.$data->id, 'method'=>'post','role'=>'form')) }}
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('name', 'Currency Name :') }}
							{{ Form::text('name', $data->currency_name, array('placeholder'=>'Enter currency name','class'=>'form-control input-lg')) }}
							{{ $errors->first('name') }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('alias', 'Alias :') }}
							{{ Form::text('alias', $data->alias, array('placeholder'=>'Enter currency abbr','class'=>'form-control input-lg')) }}
							{{ $errors->first('alias') }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('buy', 'Buy :') }}
							{{ Form::text('buy', $data->buy_value, array('placeholder'=>'Enter buy value','class'=>'form-control input-lg')) }}
							{{ $errors->first('buy') }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('sell', 'Sell :') }}
							{{ Form::text('sell', $data->sell_value, array('placeholder'=>'Enter sell value','class'=>'form-control input-lg')) }}
							{{ $errors->first('sell') }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('status', 'Status :') }}
							{{ Form::select('status', array('enabled'=>'Enabled','disabled'=>'Disabled'), $data->status, ['class'=>'form-control input-lg']) }}
							{{ $errors->first('status') }}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{{ Form::label('min', 'Min :') }}
							{{ Form::text('min', $data->min, array('placeholder'=>'Enter min amount','class'=>'form-control input-lg')) }}
							{{ $errors->first('min') }}
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