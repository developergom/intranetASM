@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Brands Management<small>Edit Brand</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/brand/' . $brand->brand_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="industry_id" id="industry_id" class="selectpicker" data-live-search="true" required="true">
                                @foreach ($industry as $row)
                                	{!! $selected = '' !!}
                                	@if($row->industry_id==$brand->subindustry->industry_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_code . ' - ' . $row->industry_name  }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('industry_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('industry_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_id" class="col-sm-2 control-label">Sub Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="subindustry_id" id="subindustry_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($subindustry as $row)
                                	{!! $selected = '' !!}
                                	@if($row->subindustry_id==$brand->subindustry_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
                                	<option value="{{ $row->subindustry_id }}" {{ $selected }}>{{ $row->subindustry_code . ' - ' . $row->subindustry_name  }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('subindustry_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('subindustry_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
        		<div class="form-group">
	                <label for="brand_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="brand_code" id="brand_code" placeholder="Brand Code" required="true" maxlength="15" value="{{ $brand->brand_code }}">
	                    </div>
	                    @if ($errors->has('brand_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('brand_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="brand_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="brand_name" id="brand_name" placeholder="Brand Name" required="true" maxlength="100" value="{{ $brand->brand_name }}">
	                    </div>
	                    @if ($errors->has('brand_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('brand_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="brand_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="brand_desc" id="brand_desc" class="form-control input-sm" placeholder="Description">{{ $brand->brand_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('brand_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('brand_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/brand') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/brand-create.js') }}"></script>
@endsection