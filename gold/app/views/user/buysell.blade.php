@extends('templates.master')

@section('page_title')
Buy and Sell Currencies
@stop

@section('content')
<div class="container main_content">
    <div class="row">
			<div class="col-md-2">@include('templates.nestedMenu')</div>
			<div class="col-md-10" style="margin-top:-70px">
            	<div class="row">
                	<h3 class="">Buy e-Currency</h3>
               		 {{ Form::open(array('url' => '/users/exchange-currencies/buy/confirm', 'method'=>'post','role'=>'form','autocomplete' => 'off')) }}
	                <div class="row">
	                    <div class="col-md-4">
	                        <div class="form-group">
	                            <label>Currency:</label>
	                            <select class="form-control currency_drop_down" name="buy_currency" id="buy_currency"></select>
	                            {{$errors->first('buy_currency')}}
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="form-group">
	                            {{ Form::label('buy_amount', 'Amount: (min:10)') }}
	                            {{ Form::text('buy_amount','',array('placeholder'=>'Specify Amount','class'=>'form-control input-lg','id'=>'buy_amount')) }}
	                            {{ $errors->first('buy_amount') }}
	                        </div>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-4"></div>
	                    <div class="col-md-8"></div>
	                </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        {{ Form::submit('Proceed',array('class'=>'btn btn-blue btn-block btn-small','id'=>'buy_button','disabled'=>'disabled')) }}
	                    </div>
	                </div>
	                {{ Form::close() }}
	            </div>
            	<br>
	            <div class="row">
	                <h3 class="">Sell e-Currency</h3>
	                {{ Form::open(array('url' => '/users/exchange-currencies/sell/review', 'method'=>'post','role'=>'form','autocomplete' => 'off')) }}
	                <div class="row">
	                    <div class="col-md-4">
	                        <div class="form-group">
	                            <label>Currency:</label>
	                            <select class="currency_drop_down form-control" name="sell_currency" id="sell_currency"></select>
	                            {{$errors->first('sell_currency')}}
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                        <div class="form-group">
	                            {{ Form::label('sell_amount', 'Amount: (min:10)') }}
	                            {{ Form::text('sell_amount','',array('placeholder'=>'Specify Amount','class'=>'form-control input-lg','id'=>'sell_amount')) }}
	                            {{ $errors->first('sell_amount') }}
	                        </div>
	                    </div>
	                </div>
	                <div class="row">
	                    <div class="col-md-2">
	                        {{ Form::submit('Proceed',array('class'=>'btn btn-blue btn-block btn-small','id'=>'sell_button','disabled'=>'disabled')) }}
	                    </div>
	                    <div class="col-md-2"></div>
	                    <div class="col-md-8"></div>
	                </div>
	                {{ Form::close() }}
	            </div>
        </div>
    </div>
</div>
@stop