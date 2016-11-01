@extends('templates.master')

@section('page_title')
	Account Summary
@stop

@section('content')
	<div class="container main_content">
		<div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
			<div class="col-md-10" style="margin-top:-70px">
				<div class="row">
					<h3 class="">Exchange Rates</h3>
					<table>
						<tr><th>Currency</th><th>Buy (NGN)</th><th>Sell (NGN)</th></tr>
						@foreach($data['currencies'] as $currency)
							<tr><td>{{$currency->currency_name}}</td><td>{{number_format($currency->buy_value, 2)}}</td><td>{{number_format($currency->sell_value, 2)}}</td></tr>
						@endforeach
					</table>
				</div>
				<br>
				<div class="row">
					<h3 class="">Last Five Transactions</h3>
					@if(!empty($data['transactions']))
					<table>
						<tr><th>Ref #</th><th>Type</th><th>Currency</th><th>Amount (NGN)</th><th>Status</th><th>Date</th></tr>
						@foreach($data['transactions'] as $transaction)
						<tr><td>{{$transaction->ref_no}}</td><td>{{$transaction->type}}</td><td>{{$transaction->currency}}</td><td>{{number_format($transaction->exchange_val, 2)}}</td><td>{{$transaction->status}}</td><td>{{date('d M Y  h:i a',strtotime($transaction->created_at))}}</td></tr>
						@endforeach
					</table>
					@else	
						<div class="message red">You have not made any transaction yet.</div>
					@endif
				</div>
				<br>
				<div class="row">
					<h3 class="">Notifications</h3>
					@if(!empty($data['notifications']))
						@foreach($data['notifications'] as $notification)
						@endforeach
					@else	
						<div class="message red">There are no messages.</div>
					@endif
				</div>
				<br>
				<div class="row">
					<h3 class="">Last Login Session</h3>
					<span>Date: {{date('d M Y  h:i a',strtotime($data['last_login']))}}</span>
				</div>
			</div>
		</div>	
	</div>
@stop