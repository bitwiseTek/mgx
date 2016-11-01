@extends('templates.master')

@section('page_title')
	System Users
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
			<h3>Users Management</h3>
			<hr class="divider"/>
			@if(!empty($data))
				<table>
					<tr>
						<th>LastName</th>
						<th>FirstName</th>
						<th>Username</th>
						<th>Phone</th>
						<th>Email</th>
						<th>Status</th>
						<th>Operation</th>
					</tr>
				@foreach($data as $user)
					<tr>
						<td>{{$user->last_name}}</td>
						<td>{{$user->first_name}}</td>
						<td>{{$user->username}}</td>
						<td>{{$user->phone_no}}</td>
						<td>{{$user->email}}</td>
						<td>{{$user->status}}</td>
						<td><a class="label label-success" href="/admin/users/{{$user->id}}">View</a></td>
					</tr>

				@endforeach
				</table>
			@else					
				You have made no transactions. Hence, nothing can be listed yet.
			@endif
		</div>
	</div>
</div>
@stop