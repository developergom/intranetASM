@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Industries Management<small>Create New Industry</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/industry') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="industry_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="industry_code" id="industry_code" placeholder="Industry Code" required="true" maxlength="5" value="{{ old('industry_code') }}">
	                    </div>
	                    @if ($errors->has('industry_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('industry_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="industry_name" id="industry_name" placeholder="Industry Name" required="true" maxlength="100" value="{{ old('industry_name') }}">
	                    </div>
	                    @if ($errors->has('industry_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('industry_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="industry_desc" id="industry_desc" class="form-control input-sm" placeholder="Description">{{ old('industry_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('industry_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('industry_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/industry') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection