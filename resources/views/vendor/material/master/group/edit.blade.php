@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Group Management<small>Edit Group</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/group/'.$group->group_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="group_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="group_name" id="group_name" placeholder="Media Group Name" required="true" maxlength="100" value="{{ $group->group_name }}">
	                    </div>
	                    @if ($errors->has('group_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('group_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="group_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="group_desc" id="group_desc" class="form-control input-sm" placeholder="Description">{{ $group->group_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('group_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('group_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/group') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection