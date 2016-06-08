@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Units Management<small>Edit Unit</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/unit/'.$unit->unit_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="unit_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="unit_code" id="unit_code" placeholder="Unit Code" required="true" maxlength="5" value="{{ $unit->unit_code }}">
	                    </div>
	                    @if ($errors->has('unit_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('unit_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="unit_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="unit_name" id="unit_name" placeholder="Unit Name" required="true" maxlength="100" value="{{ $unit->unit_name }}">
	                    </div>
	                    @if ($errors->has('unit_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('unit_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="unit_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="unit_desc" id="unit_desc" class="form-control input-sm" placeholder="Description">{{ $unit->unit_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('unit_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('unit_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/unit') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection