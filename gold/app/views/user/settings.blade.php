@extends('templates.master')

@section('page_title')
Account settings
@stop

@section('content')
<div class="container main_content">
    <div class="col-md-2">@include('templates.nestedMenu')</div>
    <div class="col-md-10" style="margin-top:-70px">
        <div class="row">
            <div class="col-md-8">
                <h3 class="">Personal Information</h3>
                <hr class="divider"/>
                {{ Form::open(array('url' => '/users/settings/info', 'method'=>'post','role'=>'form')) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('last_name', 'LastName:') }}
                            {{ Form::text('last_name',$data['info']->last_name,array('placeholder'=>'Enter your Last Name','class'=>'form-control input-lg')) }}
                            {{ $errors->first('last_name') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('first_name', 'FirstName:') }}
                            {{ Form::text('first_name',$data['info']->first_name,array('placeholder'=>'Enter your First Name','class'=>'form-control input-lg')) }}
                            {{ $errors->first('first_name') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('email', 'Email:') }}
                            {{ Form::text('email',$data['info']->email,array('class'=>'form-control input-lg','disabled'=>'disabled')) }}
                            {{ $errors->first('email') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('phone_no', 'Phone:') }}
                            {{ Form::text('phone_no',$data['info']->phone_no,array('placeholder'=>'Enter your mobile Number','class'=>'form-control input-lg')) }}
                            {{ $errors->first('phone_no') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-9">
                        @if(Session::get('editInfo_message'))
                        <div class="alert alert-info" role="alert">{{Session::get('editInfo_message')}}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        {{ Form::submit('Update',array('class'=>'btn btn-blue btn-block btn-small','name'=>'edit_info')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-md-8">
                <h3 class="">Password Settings</h3>
                <hr class="divider"/>
                {{ Form::open(array('url' => '/users/settings/password', 'method'=>'post','role'=>'form')) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('old_password', 'Current Password:') }}
                            {{ Form::password('old_password','',array('placeholder'=>'Enter Current password','class'=>'form-control input-lg')) }}
                            {{ $errors->first('old_password') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('new_password', 'New Password:') }}
                            {{ Form::password('new_password','',array('placeholder'=>'Enter New Password','class'=>'form-control input-lg')) }}
                            {{ $errors->first('new_password') }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        @if(Session::get('editPassword_message'))
                        <div class="alert alert-info" role="alert">{{Session::get('editPassword_message')}}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        {{ Form::submit('Update',array('class'=>'btn btn-blue btn-block btn-small')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-md-8">
                <h3 class="">Bank Settings</h3>
                <hr class="divider"/>
                {{ Form::open(array('url' => '/users/settings/bank-details', 'method'=>'post','role'=>'form')) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bank Name:</label>
                            <select class="form-control bank_names" name="bank_name"></select>
                            {{$errors->first('bank_name')}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('bank_account', 'Bank Account:') }}
                            {{ Form::text('bank_account',$data['info']->bank_account,array('placeholder'=>'Specify Bank Account','class'=>'form-control input-lg')) }}
                            {{ $errors->first('bank_account') }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        @if(Session::get('editBank_message'))
                        <div class="alert alert-info" role="alert">{{Session::get('editBank_message')}}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        {{ Form::submit('Update',array('class'=>'btn btn-blue btn-block btn-small')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-md-8">
                <h3 class="">eCurrency Settings</h3>
                <hr class="divider"/>
                {{ Form::open(array('url' => '/users/settings/e-wallets', 'method'=>'post','role'=>'form')) }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('perfectmoney', 'PerfectMoney:') }}
                            {{ Form::text('perfectmoney',$data['currencies']->perfectmoney,array('placeholder'=>'Enter Perfect Money currency','class'=>'form-control input-lg')) }}
                            {{ $errors->first('perfectmoney') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('perfectmoney_acct', 'PerfectMoney Account:') }}
                            {{ Form::text('perfectmoney_acct',$data['currencies']->perfectmoney_acct,array('placeholder'=>'Enter Perfect Money Acct','class'=>'form-control input-lg')) }}
                            {{ $errors->first('perfectmoney_acct') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('webmoney', 'WebMoney:') }}
                            {{ Form::text('webmoney',$data['currencies']->webmoney,array('placeholder'=>'Enter WebMoney','class'=>'form-control input-lg')) }}
                            {{ $errors->first('webmoney') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('webmoney_acct', 'WebMoney Account:') }}
                            {{ Form::text('webmoney_acct',$data['currencies']->webmoney_acct,array('placeholder'=>'Enter WebMoney Acct','class'=>'form-control input-lg')) }}
                            {{ $errors->first('webmoney_acct') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('egopay', 'EgoPay:') }}
                            {{ Form::text('egopay',$data['currencies']->egopay,array('placeholder'=>'Enter EgoPay','class'=>'form-control input-lg')) }}
                            {{ $errors->first('egopay') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('egopay_email', 'EgoPay Email:') }}
                            {{ Form::text('egopay_email',$data['currencies']->egopay_email,array('placeholder'=>'Enter EgoPay Email','class'=>'form-control input-lg')) }}
                            {{ $errors->first('egopay_email') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('payza', 'Payza:') }}
                            {{ Form::text('payza',$data['currencies']->payza,array('placeholder'=>'Enter Payza','class'=>'form-control input-lg')) }}
                            {{ $errors->first('payza') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('payza_email', 'Payza Email:') }}
                            {{ Form::text('payza_email',$data['currencies']->payza_email,array('placeholder'=>'Enter Payza Email','class'=>'form-control input-lg')) }}
                            {{ $errors->first('payza_email') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('solidtrust', 'SolidTrust:') }}
                            {{ Form::text('solidtrust',$data['currencies']->solidtrust,array('placeholder'=>'Enter SolidTrust','class'=>'form-control input-lg')) }}
                            {{ $errors->first('solidtrust') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('solidtrust_email', 'SolidTrust Email:') }}
                            {{ Form::text('solidtrust_email',$data['currencies']->solidtrust_email,array('placeholder'=>'Enter SolidTrust Email','class'=>'form-control input-lg')) }}
                            {{ $errors->first('solidtrust_email') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('okpay', 'OkPay:') }}
                            {{ Form::text('okpay',$data['currencies']->okpay,array('placeholder'=>'Enter OkPay','class'=>'form-control input-lg')) }}
                            {{ $errors->first('okpay') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('okpay_acct', 'OkPay Account:') }}
                            {{ Form::text('okpay_acct',$data['currencies']->okpay_acct,array('placeholder'=>'Enter OkPay Account','class'=>'form-control input-lg')) }}
                            {{ $errors->first('okpay_acct') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('binary', 'Binary.com:') }}
                            {{ Form::text('binary',$data['currencies']->binary,array('placeholder'=>'Enter Binary.com','class'=>'form-control input-lg')) }}
                            {{ $errors->first('binary') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('binary_acct', 'Binary.com Account:') }}
                            {{ Form::text('binary_acct',$data['currencies']->binary_acct,array('placeholder'=>'Enter Binary.com Account','class'=>'form-control input-lg')) }}
                            {{ $errors->first('binary_acct') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('bitcoin', 'Bitcoin:') }}
                            {{ Form::text('bitcoin',$data['currencies']->bitcoin,array('placeholder'=>'Enter Bitcoin','class'=>'form-control input-lg')) }}
                            {{ $errors->first('bitcoin') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('bitcoin_email', 'Bitcoin Email:') }}
                            {{ Form::text('bitcoin_email',$data['currencies']->bitcoin_email,array('placeholder'=>'Enter Bitcoin Wallet Address','class'=>'form-control input-lg')) }}
                            {{ $errors->first('bitcoin_email') }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('neteller', 'Neteller:') }}
                            {{ Form::text('neteller',$data['currencies']->neteller,array('placeholder'=>'Enter Neteller','class'=>'form-control input-lg')) }}
                            {{ $errors->first('neteller') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('neteller_email', 'Neteller Email:') }}
                            {{ Form::text('neteller_email',$data['currencies']->neteller_email,array('placeholder'=>'Enter Neteller Email','class'=>'form-control input-lg')) }}
                            {{ $errors->first('neteller_email') }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9">
                        @if(Session::get('editEwallets_message'))
                        <div class="alert alert-info" role="alert">{{Session::get('editEwallets_message')}}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        {{ Form::submit('Update',array('class'=>'btn btn-blue btn-block btn-small')) }}
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop