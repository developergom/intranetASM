@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project Task Types Management<small>Edit Project Task Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/projecttasktype/' . $projecttasktype->project_task_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="project_task_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="project_task_type_name" id="project_task_type_name" placeholder="Project Task Type Name" required="true" maxlength="100" value="{{ $projecttasktype->project_task_type_name }}">
	                    </div>
	                    @if ($errors->has('project_task_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_task_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_id" class="col-sm-2 control-label">User Approval By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="user_id" id="user_id" class="selectpicker with-ajax" data-live-search="true">
	                        	<option value="$projecttasktype->user_id">{{ $projecttasktype->user->user_firstname . ' ' . $projecttasktype->user->user_lastname }}</option>
                            </select>
	                    </div>
	                    @if ($errors->has('user_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_task_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="project_task_type_desc" id="project_task_type_desc" class="form-control input-sm" placeholder="Description">{{ $projecttasktype->project_task_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('project_task_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_task_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/projecttasktype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/projecttasktype-create.js') }}"></script>
@endsection