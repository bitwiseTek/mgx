@extends('templates.master')

@section('page_title')
  Payment Failed
@stop

@section('content')
    <div class="container main_content">
       <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 center_content">
            <div class="row content-section">
               <h3 style="color:red">{{$data['event']}}</h3>
	       <div><span style="font-weight:bold">{{$data['last_name'].' '.$data['first_name']}}</span>, your payment failed, your transaction reference is <span style="font-weight:bold">#{{$data['ref_no']}}</span></div>
         &nbsp;
          <div>Try making a new <a class="label label-success" href="/users/exchange-currencies">Exchange</a></div>
	    </div>
	  </div>
          <div class="col-md-2"></div>
       </div>
     </div>
@stop