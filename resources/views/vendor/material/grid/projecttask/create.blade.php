@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project Tasks<small>Create New Project Task</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('grid/projecttask') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="project_task_type_id" class="col-sm-2 control-label">Task Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="project_task_type_id" id="project_task_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($project_task_types as $row)
	        						{!! $selected = '' !!}
                                	@if(old('project_task_type_id')==$row->project_task_type_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->project_task_type_id }}" {{ $selected }}>{{ $row->project_task_type_name . ' - ' . $row->user->user_firstname . ' ' . $row->user->user_lastname }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('project_task_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('project_task_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="project_task_name" class="col-sm-2 control-label">Task Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="project_task_name" id="project_task_name" placeholder="Project Task Name" required="true" maxlength="100" value="{{ old('project_task_name') }}">
	                    </div>
	                    @if ($errors->has('project_task_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_task_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_task_deadline" class="col-sm-2 control-label">Task Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm date-picker" name="project_task_deadline" id="project_task_deadline" placeholder="Deadline" required="true" maxlength="10" value="{{ old('project_task_deadline') }}">
	                    </div>
	                    @if ($errors->has('project_task_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_task_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_task_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="project_task_desc" id="project_task_desc" class="form-control input-sm" placeholder="Description">{{ old('project_task_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('project_task_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_task_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="project_id" class="col-sm-2 control-label">Project Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="project_id" id="project_id" class="selectpicker with-ajax" data-live-search="true">
                            </select>
	                    </div>
	                    @if ($errors->has('project_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('project_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="dropzone" id="uploadFileArea">
	                        	
	                        </div>
	                    </div>
	                    <span class="help-block">
		                    <strong>Max filesize: 200 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
		                </span>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('grid/projecttask') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/grid/projecttask-create.js') }}"></script>
@endsection