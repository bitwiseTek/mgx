@extends('templates.master')

@section('page_title')
	It just works, with us.
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-12 hidden-xs">
			<div class="carousel carousel-fade slide" data-ride="carousel">
			    <div class="carousel-inner">
			    	<?php $count = 1; ?>
			    	@foreach($e_currencies as $currency)
			    		<div class="item {{(($count==1) ? 'active' : 'none')}}">
				          	<div class="ca_image">
				          		<img src="{{$currency->image}}" height="132" width="132">
				          	</div>
				            <div class="carousel-caption">
			           	  		<h4 style="text-align:center; font-size:3em;">{{$currency->currency_name}}.</h4>
			              		<p>Buy {{$currency->currency_name}} at N{{$currency->buy_value}}, or Sell at N{{$currency->sell_value}}.</p>
				            </div>
				        </div> 
				       <?php $count = 0; ?>
				    @endforeach
			    </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
		   <h1 style="text-align:center; font-size:3em;" class="h1_title">We take the hassle out of eCurrency exchange, Period!</h1>
		</div>
		<div class="col-md-2"></div>
	</div>
</div>
@stop
   
