@extends('templates.master')

@section('page_title')
	View Transaction
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
<h3>Transaction Details</h3>
			<a class="btn btn-green pull-right" href="/admin/transactions">Back</a>
			<hr class="divider"/>
<br>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title panel-default">Ref# :{{$data[0]->ref_no}} ({{$data[0]->status}}) - {{$data[0]->type}}</h3>
				</div>
				<div class="panel-body">
					<table class="table table-user-information">
						<tbody>
						<tr>
							<td>Name:</td>
							<td>{{$data[0]->last_name}} {{$data[0]->first_name}}</td>
						</tr>
						<tr>
							<td>Email:</td>
							<td>{{$data[0]->email}}</td>
						</tr>
						<tr>
							<td>Phone:</td>
							<td>{{$data[0]->phone_no}}</td>
						</tr>
						<tr>
							<td>Currency:</td>
							<td>{{$data[0]->currency}}</td>
						</tr>
						<tr>
							<td>Rate:</td>
							<td>$1 -> N{{number_format($data[0]->currency_val, 2)}}</td>
						</tr>
						<tr>
							<td>Amount:</td>
							<td>${{number_format($data[0]->amount, 2)}}</td>
						</tr>
						<tr>
							<td>Exchange:</td>
							<td>N{{number_format($data[0]->exchange_val, 2)}}</td>
						</tr>

						<tr>
							<td>Placed:</td>
							<td>{{date('d M Y  h:i a',strtotime($data[0]->created_at))}}</td>
						</tr>
                                                <tr>
							<td>Statement:</td>
							<td>{{($data[0]->statement) ? $data[0]->statement : 'None'}}</td>
						</tr>
                                                 @if($data[0]->type == 'Buy')
                                                    <tr>
							<td>Response Code:</td>
							<td>{{($data[0]->response_code) ? $data[0]->response_code : 'None'}}</td>
						    </tr>
                                                     <tr>
							<td>Payment Method:</td>
							<td>{{($data[0]->payment_method) ? $data[0]->payment_method : 'None'}}</td>
						     </tr>

                                                      <tr>
							<td>Payment Ref:</td>
							<td>{{($data[0]->payment_ref) ? $data[0]->payment_ref : 'None'}}</td>
						     </tr>
                                                 @endif
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
                                  @if($data[0]->status != "Failed")
					<form action="/admin/transactions/process" method="post">
						<div class="row">
							<div class="col-md-3">
								<input type="hidden" name="transaction_id" value="{{$data[0]->id}}">
								<select name="transaction_status" style="width:90%">
									<option value="">Select</option>
									<option value="completed">Completed</option>
									<option value="cancelled">Cancelled</option>
									<option value="processing">Processing</option>
								</select>
							</div>
                                                        <div class="col-md-3">
								<select name="statement" style="width:90%">
									<option value="">Select</option>
									<option value="Exchange completed successfully.">Completed Statement</option>
									<option value="Fraudulent Transaction">Cancelled Statement</option>
									<option value="Crediting e-currency account.">Processing Statement</option>
								</select>
							</div>
							<div class="col-md-3">
								<input type="submit" class="btn btn-sm btn-primary" value="Process" />
							</div>
						</div>
					</form>
                                   @endif
				</div>
			</div>
		</div>
	</div>
</div>
@stop