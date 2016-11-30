@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<table class="table table-hover">
					
						<tr>
							<td>Nama Criteria</td>
							<td>:</td>
							<td>{{$criteria->name}}</td>
						</tr>
						<tr>
							<td>Nama Admin</td>
							<td>:</td>
							<td>{{$criteria->user->name}}</td>
						</tr>
					
				</table>
			</div>
		</div>
	</div>
@stop