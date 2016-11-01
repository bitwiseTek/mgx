@extends('templates.master')

@section('page_title')
	System Configuration
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<div class="row" style="margin-bottom:30px;">
				<h3>eCurrency Settings</h3>
				<a class="btn btn-green pull-right" href="/admin/currencies/add">New</a>
				<hr class="divider"/>
				@if(Session::get('currency_success_message'))
					<div>{{Session::get('currency_success_message')}}</div>
				@endif
				@if(Session::get('currency_failed_message'))
					<div>{{Session::get('currency_failed_message')}}</div>
				@endif
				@if(!empty($data))
					<table>
						<tr>
							<th>Currency</th>
							<th>Buy</th>
							<th>Sell</th>
							<th>Active</th>
							<th>Operation</th>
						</tr>
					@foreach($data as $currency)
						<tr>
							<td>{{$currency->currency_name}}</td>
							<td>{{$currency->buy_value}}</td>
							<td>{{$currency->sell_value}}</td>
							<td>{{$currency->status}}</td>
							<td><a class="label label-success" href="/admin/currencies/view/{{$currency->id}}">View</a> |
							<a class="label label-danger" style="color:#fff; padding-left:8px;" href="/admin/currencies/delete/{{$currency->id}}">Remove</a></td>
						</tr>
					@endforeach
					</table>
				@else					
					You have not set any eCurrency.
				@endif
			</div>
			<div class="row">
				<h3>Bank Settings</h3>
				<a class="btn btn-green pull-right" href="/admin/bank-accounts/add">New</a>
				<hr class="divider"/>
				@if(Session::get('bank_message'))
					<div>{{Session::get('bank_message')}}</div>
				@endif
				@if(!empty($bank_data))
					<table>
						<tr>
							<th>Bank</th>
							<th>Active</th>
							<th>Operation</th>
						</tr>
					@foreach($bank_data as $bank)
						<tr>
							<td>{{$bank->bank_name}}</td>
							<td>{{$bank->status}}</td>
							<td><a class="label label-success" href="/admin/bank-accounts/edit/{{$bank->id}}">Edit</a> |
							<a class="label label-danger" style="color:#fff; padding-left:8px;" href="/admin/bank-accounts/delete/{{$bank->id}}">Remove</a></td>
						</tr>
					@endforeach
					</table>
				@else					
					You have not set any Bank Accounts.
				@endif
			</div>
		</div>
	</div>
</div>
@stop