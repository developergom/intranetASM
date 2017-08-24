@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/flow-display.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Flows Management<small>Detail Flow Items</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
        			<div class="col-sm-12" id="viz-container">

        			</div>
        		</div>
        		<div class="form-group">
	                <label for="flow_group_id" class="col-sm-2 control-label">Flow Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input id="flow_group_id" data-id="{{ $flow->flow_group_id }}" type="text" placeholder="Flow Group" class="form-control input-sm" readonly="true" value="{{ $flow->flowgroup->flow_group_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_name" class="col-sm-2 control-label">Flow Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_name" id="flow_name" placeholder="Flow Name" required="true" maxlength="100" value="{{ $flow->flow_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_url" class="col-sm-2 control-label">Flow URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_url" id="flow_url" placeholder="Flow URL" required="true" maxlength="255" value="{{ $flow->flow_url }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_no" class="col-sm-2 control-label">Flow No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input id="flow_no" data-id="{{ $flow->flow_no }}" type="text" placeholder="Flow No" class="form-control input-sm" value="{{ $flow->flow_no }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_prev" class="col-sm-2 control-label">Previous Flow</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" placeholder="Previous Flow" class="form-control input-sm" value="{{ $flow->flow_prev }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_by" class="col-sm-2 control-label">Flow By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" placeholder="Flow By" class="form-control input-sm" readonly="true" value="{{ $flowbyitems[$flow->flow_by] }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_id" class="col-sm-2 control-label">Role</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" placeholder="Role" class="form-control input-sm" readonly="true" value="{{ $flow->role->role_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_using_optional" class="col-sm-2 control-label">Using Optional Flow?</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" placeholder="Using Optional Flow" class="form-control input-sm" readonly="true" value="{{ ($flow->flow_using_optional=='1') ? 'Yes' : 'No' }}">
	                    </div>
	                </div>
	            </div>
	            @if($flow->flow_using_optional=='1')
	            <div class="form-group">
	                <label for="conditional" class="col-sm-2 control-label">Conditional</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" placeholder="Conditional" class="form-control input-sm" readonly="true" value="{{ $flow->flow_condition . ' ' . $flow->flow_condition_value }}">
	                    </div>
	                </div>
	            </div>
	            @endif
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/flow') }}" class="btn btn-danger btn-sm">Back</a>
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
	var flow_group_id = $('#flow_group_id').data('id');
	var current = $('#flow_no').data('id');
	generateFlowViz(flow_group_id, current);
});
</script>
@endsection