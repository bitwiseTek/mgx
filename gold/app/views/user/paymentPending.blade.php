@extends('templates.master')

@section('page_title')
  Payment Pending
@stop

@section('content')
    <div class="container main_content">
       <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 center_content">
            <div class="row content-section">
               <h3 style="color:green">{{$data['event']}}</h3>
	         <div><span style="font-weight:bold">{{$data['last_name'].' '.$data['first_name']}}</span>, your payment is pending. your transaction reference is <span style="font-weight:bold">#{{$data['ref_no']}} - NB: Do not re-try this transaction</span>.

       <p>You will be notified when we receive feedback from your bank, thanks.</p>
       &nbsp;
       <div>Back to <a class="label label-success" href="/users/summary">dashboard</a></div>
    </div>
	    </div>
	  </div>
          <div class="col-md-2"></div>
       </div>
     </div>
@stop