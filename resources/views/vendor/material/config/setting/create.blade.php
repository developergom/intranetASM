@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Application Settings Management<small>Create New Setting</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('config/setting') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="setting_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="setting_code" id="setting_code" placeholder="Setting Code" required="true" maxlength="100" value="{{ old('setting_code') }}">
	                    </div>
	                    @if ($errors->has('setting_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('setting_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="setting_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="setting_name" id="setting_name" placeholder="Setting Name" required="true" maxlength="100" value="{{ old('setting_name') }}">
	                    </div>
	                    @if ($errors->has('setting_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('setting_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="setting_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="setting_desc" id="setting_desc" class="form-control input-sm" required placeholder="Description">{{ old('setting_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('setting_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('setting_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="setting_value" class="col-sm-2 control-label">Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="setting_value" id="setting_value" class="form-control input-sm" required placeholder="Value">{{ old('setting_value') }}</textarea>
	                    </div>
	                    @if ($errors->has('setting_value'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('setting_value') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('config/setting') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection