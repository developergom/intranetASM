@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Action Control Management<small>Create New Action Control</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/action') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="action_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_name" id="action_name" placeholder="Action Control Name" required="true" maxlength="100" value="{{ old('action_name') }}">
	                    </div>
	                    @if ($errors->has('action_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_alias" class="col-sm-2 control-label">Alias</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_alias" id="action_alias" placeholder="Action Control Alias" required="true" maxlength="50" value="{{ old('action_alias') }}">
	                    </div>
	                    @if ($errors->has('action_alias'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_alias') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="action_desc" id="action_desc" class="form-control input-sm" placeholder="Action Control Description">{{ old('action_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('action_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/action') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection