@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project<small>Create New Project</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('grid/project') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="project_name" class="col-sm-2 control-label">Project Name</label>
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
	                <label for="project_periode_start" class="col-sm-2 control-label">Project Start</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm date-picker" name="project_periode_start" id="project_periode_start" placeholder="Project Start e.g 17/08/1945" required="true" maxlength="10" value="{{ old('project_periode_start') }}">
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
	                        <input type="text" class="form-control input-sm date-picker" name="project_periode_end" id="project_periode_end" placeholder="Project End e.g 17/08/1945" required="true" maxlength="10" value="{{ old('project_periode_end') }}">
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
	            	<label for="pic" class="col-sm-2 control-label">PIC</label>
	            	<div class="col-sm-10">
	            		<select name="pic" id="pic" class="selectpicker" data-live-search="true" required="true">
        					@foreach($pics as $row)
        						{!! $selected = '' !!}
                            	@if(old('pic')==$row->user_id)
                                	{!! $selected = 'selected' !!}
                            	@endif
        						<option value="{{ $row->user_id }}" {{ $selected }}>{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
        					@endforeach
        				</select>
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
<script src="{{ url('js/dropzone.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/grid/project-create.js') }}"></script>
@endsection