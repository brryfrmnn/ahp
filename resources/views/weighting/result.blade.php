@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-body">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Alternative</th>
									<th>Hasil Perbandingan Eigen Alternative x Eigen Criteria</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($results as $result)
									<tr>
										<td>{{$result->alternative->name}}</td>
										<td>{{$result->value}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-body">
						Berdasarkan data tabel diatas, kita bisa simpulkan bahwa Alternative <strong>{{$results[0]->alternative->name}}</strong> memiliki nilai <strong>{{$results[0]->value}}</strong> sehingga <strong>{{$results[0]->name}}</strong> menjadi Alternative yang disarankan.
					</div>
				</div>
			</div>
		</div>
	</div>
@stop