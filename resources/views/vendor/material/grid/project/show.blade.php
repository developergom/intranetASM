@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project<small>View Project</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="project_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
							<input type="text" class="form-control" name="project_code" id="project_code" placeholder="Project Code" maxlength="20" value="{{ $project->project_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
        		<div class="form-group">
	                <label for="project_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
							<input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name" required="true" maxlength="100" value="{{ $project->project_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                       	<input class="form-control" value="{{ $project->client->client_name }}" placeholder="Client" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="project_desc" id="project_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $project->project_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('grid/project') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection