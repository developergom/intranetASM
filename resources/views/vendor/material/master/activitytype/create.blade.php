@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Activity Types Management<small>Create New Activity Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/activitytype') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="activity_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="activity_type_name" id="activity_type_name" placeholder="Activity Type Name" required="true" maxlength="100" value="{{ old('activity_type_name') }}">
	                    </div>
	                    @if ($errors->has('activity_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('activity_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="activity_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="activity_type_desc" id="activity_type_desc" class="form-control input-sm" placeholder="Description">{{ old('activity_type_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('activity_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('activity_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/activitytype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection