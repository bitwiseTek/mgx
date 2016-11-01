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
            <h3 class="">Transaction Review</h3>
            <p style="width:60%;line-height:24px;">You are purchasing ${{$data['currency_amount']}} of {{$data['currency_name']}}.</p><br>
            <div class="row">
                <div class="col-md-5">
                    <h4 class="">Pay Online (Interswitch)</h4>
                    <form name="intPaymentForm" action="https://webpay.interswitchng.com/paydirect/pay" method="post">
                        <input name="cust_name" type="hidden" value="{{$data['first_name']}}" />
                        <input name="cust_name_desc" type="hidden" value="Paying customer first name." />
                        <input type="hidden" name="user_id" value="{{$data['user_id']}}" />
                        <input type="hidden" name="txn_ref" value="{{$data['ref_no']}}" />
                        <input type="hidden" name="product_id" value="{{$data['product_id']}}" />
                        <input type="hidden" name="amount" value="{{$data['amount']}}" />
                        <input type="hidden" name="currency" value="{{$data['currency']}}" />
                        <input type="hidden" name="pay_item_id" value="{{$data['pay_item_id']}}" />
                        <input name="pay_item_name" type="hidden" value="You are purchasing ${{$data['currency_amount']}} of {{$data['currency_name']}}." />
                        <input name="cust_id" type="hidden" value="{{$data['last_name']}}" />
                        <input name="cust_id_desc" type="hidden" value="last_name" />
                        <input type="hidden" name="site_name" value="http://maplexchange.com" />
                        <input type="hidden" name="site_redirect_url" value="{{$data['redirect_url']}}" />
                        <input type="hidden" name="hash" value="{{$data['hash_val']}}" />
                        <div class="row">
                            <div class="col-md-12">
                                <span style="font-weight:bold; margin-right:10px">Customer: </span> {{$data['first_name']}} {{$data['last_name']}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span style="font-weight:bold; margin-right:10px">Amount: </span> N{{number_format($data['amount_summary'], 2)}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span style="font-weight:bold; margin-right:10px">Ref #: </span> {{$data['ref_no']}}
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div class="col-md-4"><input type="submit" class="btn btn-blue btn-block btn-small" value="Continue" /></div>
                            <div class="col-md-8"></div>
                        </div>
                    </form>
                </div>
                <div class="col-md-2">OR</div>
                <div class="col-md-5">
                    <h4 class="">Pay by Bank</h4>
                    Please contact support for bank account details.
                </div>
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