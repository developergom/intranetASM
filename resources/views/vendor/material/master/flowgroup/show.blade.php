@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/flow-display.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Flow Group Management<small>View Flow Group</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="flow_group_name" class="col-sm-2 control-label">Flow Group Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input data-id="{{ $flowgroup->flow_group_id }}" type="text" class="form-control input-sm" name="flow_group_name" id="flow_group_name" placeholder="flow_group Name" required="true" maxlength="100" value="{{ $flowgroup->flow_group_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="module_id" class="col-sm-2 control-label">URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" placeholder="Module URL" required="true" maxlength="100" value="{{ $flowgroup->module->module_url }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_group_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        {!! $flowgroup->flow_group_desc !!}
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
        			<div class="col-sm-12" id="viz-container">

        			</div>
        		</div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/flowgroup') }}" class="btn btn-danger btn-sm">Back</a>
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

@section('customjs')
<script src="{{ url('js/master/flow-display.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	var flow_group_id = $('#flow_group_name').data('id');

	generateFlowViz(flow_group_id);
});
</script>
@endsection