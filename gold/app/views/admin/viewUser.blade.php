@extends('templates.master')

@section('page_title')
	View User
@stop

@section('content')
<div class="container main_content">
	<div class="row">
		<div class="col-md-2">@include('templates.nestedMenu')</div>
		<div class="col-md-10" style="margin-top:-70px">
<h3>User Details</h3>
			<a class="btn btn-green pull-right" href="/admin/users">Back</a>
			<hr class="divider"/>
<br>
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title panel-default">{{ucfirst($data->first_name)}} {{ucfirst($data->last_name)}} ({{$data->status}})</h3>
				</div>
				<div class="panel-body">
					<table class="table table-user-information">
						<tbody>
						<tr>
							<td>Username:</td>
							<td>{{$data->username}}</td>
						</tr>
						<tr>
							<td>Email:</td>
							<td>{{$data->email}}</td>
						</tr>
						<tr>
							<td>Phone:</td>
							<td>{{$data->phone_no}}</td>
						</tr>
						<tr>
							<td>Bank:</td>
							<td>{{(($data->bank_name) ? $data->bank_name : 'Not Set')}}</td>
						</tr>

						<tr>
							<td>Account No:</td>
							<td>{{(($data->bank_account) ? $data->bank_account : 'Not Set')}}</td>
						</tr>

						<tr>
							<td>Address:</td>
							<td>{{(($data->address) ? $data->address : 'Not Set')}}</td>
						</tr>

						<tr>
							<td>State:</td>
							<td>{{$data->state}}</td>
						</tr>

						<tr>
							<td>Country:</td>
							<td>{{$data->country}}</td>
						</tr>

						<tr>
							<td>Date of Birth:</td>
							<td>{{$data->dob}}</td>
						</tr>

						<tr>
							<td>Zip Code:</td>
							<td>{{$data->zip_code}}</td>
						</tr>

						<tr>
							<td>Status</td>
							<td>{{$data->status}}</td>
						</tr>

						<tr>
							<td>Last Login:</td>
							<td>{{date('d M Y  h:i a',strtotime($data->last_login))}}</td>
						</tr>

						<tr>
							<td>Created At:</td>
							<td>{{date('d M Y  h:i a',strtotime($data->created_at))}}</td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<form action="/admin/users/status/{{$data->id}}" method="post">
						@if($data->status == 'Enabled')
							<input type="hidden" value="Disabled" name="status" />
							<input type="submit" class="btn btn-sm btn-primary" value="Block User" />
						@else
							<input type="hidden" value="Enabled" name="status" />
							<input type="submit" class="btn btn-sm btn-primary" value="Allow User" />
						@endif
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop