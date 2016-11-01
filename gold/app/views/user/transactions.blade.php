@extends('templates.master')

@section('page_title')
Transactions
@stop

@section('content')
	<div class="container main_content">
   		<div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
			<div class="col-md-10" style="margin-top:-70px">
                <h3 class="">Transactions History</h3>
                  @if(Session::get('message'))
	             <div>{{Session::get('message')}}</div>
	          @endif
                @if(!empty($data))
                <table>
                    <tr>
                        <th>Type</th>
                        <th>Currency</th>
                        <th>Amount (NGN)</th>
                        <th>Status</th>
			<th>Date</th>
                        <th>Operation</th>
                    </tr>
                    @foreach($data as $transaction)
                    <tr>
                        <td>{{$transaction->type}}</td>
                        <td>{{$transaction->currency}}</td>
                        <td>{{number_format($transaction->exchange_val, 2)}}</td>
                        <td>{{$transaction->status}}</td>
                        <td>{{date('d M Y  h:i a',strtotime($transaction->created_at))}}</td>
                        <td><a class="label label-success" href="/users/transactions/{{$transaction->id}}">View</a>
                     
                        </td>
                    </tr>
                    @endforeach
                </table>
                @else
                	You have made no transactions.
                @endif
            </div>
        </div>
    </div>
@stop
