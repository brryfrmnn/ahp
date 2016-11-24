@extends('layouts.app')
@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form  class="form-inline" action="{{route('weighting.store')}}" method="POST" role="form">
					<legend>Form title</legend>
								
						
							<div class="form-group">
							    <div class="col-weighting-10">
							      <select name="value" id="input" class="form-control" required="required">
							      	@foreach ($criterias as $criteria)
								    	<option value="{{$criteria->id}}">{{$criteria->name}}</option>
								   	@endforeach
								    </select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-10">
							      <select name="value" id="input" class="form-control" required="required">
							      		<option value="1">1</option>
							      		<option value="2">2</option>
							      		<option value="3">3</option>
							      		<option value="4">4</option>
							      		<option value="5">5</option>
							      		<option value="6">6</option>
							      		<option value="7">7</option>
							      		<option value="8">8</option>
							      		<option value="9">9</option>		
								   </select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-10">
							      <select name="value" id="input" class="form-control" required="required">
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