@extends('templates.master')

@section('page_title')
	Oya recover ur password
@stop

@section('content')

	<div class="container main_content">
		<div class="row">
	   		 <div class="col-md-6 ">
	    		<h3>I want my password back<small> we go help u get am.</small></h3>
				<hr class="colorgraph">
				<form action="/login/password-recovery" method="POST">
					<div class="form-group">
						<label>Enter Registration Email or Username :</label>
				    	<input type="text" placeholder="Enter Email or Username"  name="email" class="form-control">
				    </div>
				    <div class="form-group">
				    <input type="submit" value="Get Token" class="btn btn-small btn-blue">
				    </div>

				   	@if(Session::get('recovery_message'))
				   		 <div>{{Session::get('recovery_message')}}</div>
				   	@endif
				</form>
			</div>
		</div>
	</div>
	
@stop