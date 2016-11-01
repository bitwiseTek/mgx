@extends('templates.master')

@section('page_title')
	Transaction Details
@stop

@section('content')
	<div class="container main_content">
		<div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
			<div class="col-md-10" style="margin-top:-70px">
				<h3 class="">Transaction Details</h3>
				<a class="btn btn-green pull-right" href="/users/transactions">Back</a>
				<hr class="divider"/>
<br>
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title panel-default">Ref# :{{$data->ref_no}} ({{$data->status}})</h3>
					</div>
					<div class="panel-body">
						<table class="table table-user-information">
							<tbody>
							<tr>
								<td>Currency:</td>
								<td>{{$data->currency}}</td>
							</tr>
							<tr>
								<td>Exchange Rate:</td>
								<td>$1 -> N{{number_format($data->currency_val, 2)}}</td>
							</tr>
							<tr>
								<td>Amount:</td>
								<td>${{number_format($data->amount, 2)}}</td>
							</tr>
							<tr>
								<td>Exchange Made:</td>
								<td>N{{number_format($data->exchange_val, 2)}}</td>
							</tr>
							<tr>
								<td>Order Placed:</td>
								<td>{{date('d M Y  h:i a',strtotime($data->created_at))}}</td>
							</tr>
                                                        <tr>
								<td>Statement:</td>
								<td>{{($data->statement) ? $data->statement : 'None' }}</td>
							</tr>
                                                         <tr>
								<td>Payment Method:</td>
								<td>{{($data->payment_method) ? $data->payment_method : 'None' }}</td>
							</tr>
                                                         <tr>
								<td>Payment Ref:</td>
								<td>{{($data->payment_ref) ? $data->payment_ref : 'None' }}</td>
							</tr>
							</tbody>
						</table>
					</div>
					<div class="panel-footer"></div>
				</div>
			</div>	
		</div>
	</div>
@stop