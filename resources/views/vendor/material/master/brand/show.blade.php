@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Brands Management<small>View Detail Brand</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="brand_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="brand_code" id="brand_code" placeholder="Brand Code" required="true" maxlength="15" value="{{ $brand->brand_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
        		<div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
							<input type="text" class="form-control input-sm" name="industry_id" id="industry_id" placeholder="Industry Name" required="true" maxlength="100" value="{{ $brand->subindustry->industry->industry_name }}" disabled="true">	                        
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_id" class="col-sm-2 control-label">Sub Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="subindustry_id" id="subindustry_id" placeholder="Sub Industry Name" required="true" maxlength="100" value="{{ $brand->subindustry->subindustry_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="brand_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="brand_name" id="brand_name" placeholder="Brand Name" required="true" maxlength="100" value="{{ $brand->brand_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="brand_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="brand_desc" id="brand_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $brand->brand_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/brand') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection