@extends('templates.master')
@section('page_title')
    Review Exchange.
@stop

@section('content')
	<div class="container main_content">
    	<div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
			<div class="col-md-10" style="margin-top:-70px">
                @if($data['status']==true)
                   <div class="row">
                          <h3 class="">Transaction Review</h3>
                   	     <p style="width:60%;line-height:24px;">You are selling ${{$data['input']['sell_amount']}} of {{$data['currency']->currency_name}} at N{{$data['currency']->sell_value}}, you will paid N{{number_format($data['currency']->sell_value*$data['input']['sell_amount'], 2)}} to your bank account.</p>
	                     <form name="intPaymentForm" action="/users/exchange-currencies/sell" method="post">
	                        <input type="hidden" name="sell_amount" value="{{$data['input']['sell_amount']}}" />
	                        <input type="hidden" name="sell_currency" value="{{$data['currency']->currency_name}}" />	                        
	                        <div class="row" style="margin-top:20px">
	                       	    <div class="col-md-2"><input type="submit" class="btn btn-blue btn-block btn-small" value="Continue" /></div>
	                            <div class="col-md-8"></div>
	                        </div>
	                    </form>
	               </div>                  
                @else
                <div class="row">
                  <h3 class="">Opps, your attention is needed!</h3>
                    <p style="width:60%;line-height:24px;">
                     You have not set your e-currency account for this particular e-currency,
                     please go back to <a class="label label-success" href="/users/settings">Settings</a> and do so, thanks.
                   </p>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop