@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project<small>Edit Project</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('grid/project/' . $project->project_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
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
							<input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name" required="true" maxlength="100" value="{{ $project->project_name }}">
	                    </div>
	                    @if ($errors->has('project_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_periode_start" class="col-sm-2 control-label">Project Start</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm date-picker" name="project_periode_start" id="project_periode_start" placeholder="Project Start e.g 17/08/1945" required="true" maxlength="10" value="{{ $project_start }}">
	                    </div>
	                    @if ($errors->has('project_periode_start'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_periode_start') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_periode_end" class="col-sm-2 control-label">Project End</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm date-picker" name="project_periode_end" id="project_periode_end" placeholder="Project End e.g 17/08/1945" required="true" maxlength="10" value="{{ $project_end }}">
	                    </div>
	                    @if ($errors->has('project_periode_end'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_periode_end') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id" id="client_id" class="selectpicker" data-live-search="true">
	                        	<option value="{{ $project->client_id }}" selected>{{ $project->client->client_name }}</option>
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="project_desc" id="project_desc" class="form-control input-sm" placeholder="Description">{{ $project->project_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('project_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('grid/project') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/grid/project-create.js') }}"></script>
@endsection