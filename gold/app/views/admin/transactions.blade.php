@extends('templates.master')

@section('page_title')
	System Transactions
@stop

@section('content')
<div class="container main_content">
	<div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<h3>Transactions Management</h3>
			<hr class="divider"/>
			@if(!empty($data))
				<table>
					<tr>

						<th>Type</th>
						<th>Currency</th>
						<th>Amount (NGN)</th>
						<th>Status</th>
						<th>Date</th>
						<th>E-mail</th>
						<th>Operation</th>
					</tr>
				@foreach($data as $transaction)
					<tr>

						<td>{{$transaction->type}}</td>
						<td>{{$transaction->currency}}</td>
                                                <td>{{number_format($transaction->exchange_val, 2)}}</td>
						<td>{{$transaction->status}}</td>
						<td>{{date('d M Y  h:i a',strtotime($transaction->created_at))}}</td>
						<td>{{$transaction->email}}</td>
						<td><a class="label label-success" href="/admin/transactions/{{$transaction->id}}">View</a>
@if($transaction->status == 'Pending' && $transaction->type == 'Buy')<a class="label label-primary" href="/admin/query-payment-status/{{$transaction->id}}">Query</a>@endif
</td>
					</tr>

				@endforeach
				</table>
			@else					
				You have made no transactions. Hence, nothing can be listed yet.
			@endif
		</div>
	</div>
</div>
@stop