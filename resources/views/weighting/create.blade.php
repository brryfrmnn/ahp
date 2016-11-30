@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form  class="form-inline" action="{{route('weighting.store')}}" method="POST" role="form">
					<legend>Nilai Bobot Kriteria</legend>
								{{csrf_field()}}
						
							<div class="form-group">
							    <div class="col-weighting-10">
							      <select name="first_criteria_id" id="input" class="form-control" required="required">
							      	@foreach ($criterias as $criteria)
								    	<option value="{{$criteria->id}}">{{$criteria->name}}</option>
								   	@endforeach
								    </select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-10">
							      <select name="value" id="input" class="form-control" required="required">
							      		<option value="1">1 - Equal Importance</option>
							      		<option value="2">2 - Intermediate value </option>
							      		<option value="3">3 - Weak Importance of one over than</option>
							      		<option value="4">4 - Intermediate value</option>
							      		<option value="5">5 - Strong Importance than</option>
							      		<option value="6">6 - Intermediate value</option>
							      		<option value="7">7 Demonstrated Importance than </option>
							      		<option value="8">8 - Intermediate value</option>
							      		<option value="9">9 - Absolute importance than </option>		
								   </select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-10">
							      <select name="second_criteria_id" id="input" class="form-control" required="required">
							      	@foreach ($criterias as $criteria)
								    	<option value="{{$criteria->id}}">{{$criteria->name}}</option>
								   	@endforeach
								    </select>
							    </div>
							</div>
						
					
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
@endsection