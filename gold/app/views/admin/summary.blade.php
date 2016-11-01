@extends('templates.master')

@section('page_title')
System Summary
@stop

@section('content')
<div class="container main_content">
    <div class="row">
        <div class="col-md-2">@include('templates.nestedMenu')</div>
        <div class="col-md-10" style="margin-top:-70px">
            <div class="row">
                <h4>Users</h4><br>
                <div col-md-12">
                    <a style="margin-right:15px; height:80px; width:100px" href="#" class="btn btn-success btn-lg" role="button"> {{$data['total_users']}}<br/>Total</a>
                    <a style="margin-right:15px; height:80px; width:100px"href="#" class="btn btn-info btn-lg" role="button"> {{$data['total_active_users']}}<br/>Active</a>
                    <a style="height:80px; width:100px" href="#" class="btn btn-primary btn-lg" role="button"> {{$data['total_inactive_users']}}<br/>In-Active</a>
                </div>
            </div>
             <br>
            <div class="row">
                <h4>Transactions</h4><br>
                <div col-md-12">
                    <a style="margin-right:15px; height:80px; width:100px" href="#" class="btn btn-success btn-lg" role="button"> {{$data['total_transactions']}}<br/>Total</a>
                    <a style="margin-right:15px; height:80px; width:100px"href="#" class="btn btn-primary btn-lg" role="button"> {{$data['total_buy_transactions']}}<br/>Buy</a>
                    <a style="margin-right:15px; height:80px; width:100px"href="#" class="btn btn-primary btn-lg" role="button"> {{$data['total_sell_transactions']}}<br/>Sell</a>
                    <a style="height:80px; width:100px" href="#" class="btn btn-info btn-lg" role="button"> {{$data['total_completed_transactions']}}<br/>Completed</a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop