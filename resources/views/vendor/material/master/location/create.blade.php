@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Location Management<small>Create New Location</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/location') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="location_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_name" id="location_name" placeholder="Location Name" required="true" maxlength="50" value="{{ old('location_name') }}">
	                    </div>
	                    @if ($errors->has('location_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('location_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_address" class="col-sm-2 control-label">Address</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_address" id="location_address" placeholder="Location Address" required="true" maxlength="150" value="{{ old('location_address') }}">
	                    </div>
	                    @if ($errors->has('location_address'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('location_address') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_city" class="col-sm-2 control-label">City</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_city" id="location_city" placeholder="Location City" required="true" maxlength="50" value="{{ old('location_city') }}">
	                    </div>
	                    @if ($errors->has('location_city'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('location_city') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="location_desc" id="location_desc" class="form-control input-sm" placeholder="Description">{{ old('location_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('location_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('location_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/location') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection