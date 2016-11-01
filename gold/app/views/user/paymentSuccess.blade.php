@extends('templates.master')

@section('page_title')
  Payment Successfull
@stop

@section('content')
    <div class="container main_content">
       <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 center_content">
            <div class="row content-section">
               <h3 style="color:green">{{$data['event']}}</h3>
	         <div><span style="font-weight:bold">{{$data['last_name'].' '.$data['first_name']}}</span>, your payment was successful. your transaction reference is <span style="font-weight:bold">#{{$data['ref_no']}}</span>.

       <p>An email has been sent to you as regards your payment, thanks.</p>
       &nbsp;
       <div>Back to <a class="label label-success" href="/users/summary">dashboard</a></div>
    </div>
	    </div>
	  </div>
          <div class="col-md-2"></div>
       </div>
     </div>
@stop