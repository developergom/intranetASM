@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Sub Industries Management<small>View Sub Industry</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-7">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="industry_id" id="industry_id" placeholder="Industry" required="true" value="{{ $subindustry->industry->industry_code . ' - ' . $subindustry->industry->industry_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-7">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="subindustry_code" id="subindustry_code" placeholder="Sub Industry Code" required="true" maxlength="10" value="{{ $subindustry->subindustry_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="subindustry_name" id="subindustry_name" placeholder="Sub Industry Name" required="true" maxlength="100" value="{{ $subindustry->subindustry_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea class="form-control input-sm" placeholder="Description" disabled="true">{{ $subindustry->subindustry_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/subindustry') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection