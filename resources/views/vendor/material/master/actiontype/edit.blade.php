@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Action Types Management<small>Edit Action Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/actiontype/'.$actiontype->action_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="action_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_type_name" id="action_type_name" placeholder="Action Type Name" required="true" maxlength="100" value="{{ $actiontype->action_type_name }}">
	                    </div>
	                    @if ($errors->has('action_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="action_type_desc" id="action_type_desc" class="form-control input-sm" placeholder="Description">{{ $actiontype->action_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('action_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/actiontype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection