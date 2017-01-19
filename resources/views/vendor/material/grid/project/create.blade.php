@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project<small>Create New Project</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('grid/project') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="project_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
							<input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name" required="true" maxlength="100" value="{{ old('project_name') }}">
	                    </div>
	                    @if ($errors->has('project_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id" id="client_id" class="selectpicker" data-live-search="true">
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="project_desc" id="project_desc" class="form-control input-sm" placeholder="Description">{{ old('project_desc') }}</textarea>
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
@endsection

@section('customjs')
<script src="{{ url('js/grid/project-create.js') }}"></script>
@endsection