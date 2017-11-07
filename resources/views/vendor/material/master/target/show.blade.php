@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Target Management<small>View Target</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="target_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_code" id="target_code" placeholder="Target Code" maxlength="20" value="{{ $target->target_code }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_name" id="media_id" placeholder="Media Name" value="{{ $target->media->media_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="industry_name" id="industry_id" placeholder="Industry Name" value="{{ $target->industry->industry_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="target_month" class="col-sm-2 control-label">Month</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_month" id="target_month" placeholder="Target Month" value="{{ $target->target_month }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="target_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_year" id="target_year" placeholder="Target Year" value="{{ $target->target_year }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="target_amount" class="col-sm-2 control-label">Target Amount</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_amount" id="target_amount" placeholder="Target Amount ex: 1000000" maxlength="15" value="{{ number_format($target->target_amount) }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/target') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection