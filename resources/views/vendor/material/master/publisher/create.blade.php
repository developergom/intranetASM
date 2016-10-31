@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Publisher Management<small>Create New Publisher</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/publisher') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="publisher_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="publisher_code" id="publisher_code" placeholder="Publisher Code" required="true" maxlength="5" value="{{ old('publisher_code') }}">
	                    </div>
	                    @if ($errors->has('publisher_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('publisher_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="publisher_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="publisher_name" id="publisher_name" placeholder="Publisher Name" required="true" maxlength="100" value="{{ old('publisher_name') }}">
	                    </div>
	                    @if ($errors->has('publisher_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('publisher_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="publisher_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="publisher_desc" id="publisher_desc" class="form-control input-sm" placeholder="Description">{{ old('publisher_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('publisher_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('publisher_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/publisher') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection