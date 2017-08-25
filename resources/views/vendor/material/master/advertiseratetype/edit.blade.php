@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Rate Types Management<small>Edit Advertise Rate Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/advertiseratetype/'.$advertiseratetype->advertise_rate_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="advertise_rate_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_type_name" id="advertise_rate_type_name" placeholder="Advertise Rate Type Name" required="true" maxlength="100" value="{{ $advertiseratetype->advertise_rate_type_name }}">
	                    </div>
	                    @if ($errors->has('advertise_rate_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="advertise_rate_type_desc" id="advertise_rate_type_desc" class="form-control input-sm" placeholder="Description">{{ $advertiseratetype->advertise_rate_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('advertise_rate_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/advertiseratetype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection