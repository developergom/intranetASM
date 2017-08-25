@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project Task Types Management<small>View Project Task Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="project_task_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="project_task_type_name" id="project_task_type_name" placeholder="Project Task Type Name" required="true" maxlength="100" value="{{ $projecttasktype->project_task_type_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_id" class="col-sm-2 control-label">User Approval By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input class="form-control input-sm" value="{{ $projecttasktype->user->user_firstname . ' ' . $projecttasktype->user->user_lastname }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_task_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        {!! $projecttasktype->project_task_type_desc !!}
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/projecttasktype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection