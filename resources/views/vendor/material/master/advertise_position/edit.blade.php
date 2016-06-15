@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Positions Management<small>Edit Advertise Position</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/advertiseposition/'.$advertiseposition->advertise_position_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="advertise_position_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_position_name" id="advertise_position_name" placeholder="Advertise Position Name" required="true" maxlength="100" value="{{ $advertiseposition->advertise_position_name }}">
	                    </div>
	                    @if ($errors->has('advertise_position_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_position_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_position_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="advertise_position_desc" id="advertise_position_desc" class="form-control input-sm" placeholder="Description">{{ $advertiseposition->advertise_position_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('advertise_position_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_position_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/advertiseposition') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection