@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Sub Industries Management<small>Edit Sub Industry</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/subindustry/'.$subindustry->subindustry_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="industry_id" id="industry_id" class="selectpicker" data-live-search="true" required="true">
                                @foreach ($industry as $row)
                                	{!! $selected = '' !!}
                                	@if($row->industry_id==$subindustry->industry_id)
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
	                <label for="subindustry_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="subindustry_code" id="subindustry_code" placeholder="Sub Industry Code" required="true" maxlength="10" value="{{ $subindustry->subindustry_code }}">
	                    </div>
	                    @if ($errors->has('subindustry_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('subindustry_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="subindustry_name" id="subindustry_name" placeholder="Sub Industry Name" required="true" maxlength="100" value="{{ $subindustry->subindustry_name }}">
	                    </div>
	                    @if ($errors->has('subindustry_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('subindustry_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="subindustry_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="subindustry_desc" id="subindustry_desc" class="form-control input-sm" placeholder="Description">{{ $subindustry->subindustry_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('subindustry_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('subindustry_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/subindustry') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection