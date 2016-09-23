@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Module Management<small>View Module</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="module_url" class="col-sm-2 control-label">Module URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="module_url" id="module_url" placeholder="Module URL" required="true" maxlength="100" value="{{ $module->module_url }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="module_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="module_desc" id="module_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $module->module_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_id" class="col-sm-2 control-label">Action(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($actions as $row)
                            	@foreach ($module->actions as $action)
                            		@if($action->action_id==$row->action_id)
                            			<span class="badge">{{ $row->action_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/module') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection