@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Location Management<small>View Location</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="location_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_name" id="location_name" placeholder="Location Name" required="true" maxlength="100" value="{{ $location->location_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_address" class="col-sm-2 control-label">Address</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_address" id="location_address" placeholder="Location Address" required="true" maxlength="150" value="{{ $location->location_address }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_city" class="col-sm-2 control-label">City</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_city" id="location_city" placeholder="Location City" required="true" maxlength="50" value="{{ $location->location_city }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        {!! $location->location_desc !!}
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/location') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection