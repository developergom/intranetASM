@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Target Management<small>Create New Target</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/target') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="target_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_code" id="target_code" placeholder="Target Code" maxlength="20" value="{{ old('target_code') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('target_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('target_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id" id="media_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_id==old('media_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="industry_id" id="industry_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
	                        	@foreach ($industries as $row)
                                	{!! $selected = '' !!}
                                	@if($row->industry_id==old('industry_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
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
	                <label for="target_month" class="col-sm-2 control-label">Month</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="target_month" id="target_month" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
	                        	<option value="01" {{ (old('target_month')=='01') ? 'selected' : '' }}>January</option>
	                        	<option value="02" {{ (old('target_month')=='02') ? 'selected' : '' }}>February</option>
	                        	<option value="03" {{ (old('target_month')=='03') ? 'selected' : '' }}>March</option>
	                        	<option value="04" {{ (old('target_month')=='04') ? 'selected' : '' }}>April</option>
	                        	<option value="05" {{ (old('target_month')=='05') ? 'selected' : '' }}>May</option>
	                        	<option value="06" {{ (old('target_month')=='06') ? 'selected' : '' }}>June</option>
	                        	<option value="07" {{ (old('target_month')=='07') ? 'selected' : '' }}>July</option>
	                        	<option value="08" {{ (old('target_month')=='08') ? 'selected' : '' }}>August</option>
	                        	<option value="09" {{ (old('target_month')=='09') ? 'selected' : '' }}>September</option>
	                        	<option value="10" {{ (old('target_month')=='10') ? 'selected' : '' }}>October</option>
	                        	<option value="11" {{ (old('target_month')=='11') ? 'selected' : '' }}>November</option>
	                        	<option value="12" {{ (old('target_month')=='12') ? 'selected' : '' }}>December</option>
                            </select>
	                    </div>
	                    @if ($errors->has('target_month'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('target_month') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="target_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_year" id="target_year" placeholder="Target Year ex: 2017" maxlength="4" value="{{ old('target_year') }}">
	                    </div>
	                    @if ($errors->has('target_year'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('target_year') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="target_amount" class="col-sm-2 control-label">Target Amount</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="target_amount" id="target_amount" placeholder="Target Amount ex: 1000000" maxlength="15" value="{{ old('target_amount') }}">
	                    </div>
	                    @if ($errors->has('target_amount'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('target_amount') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="result_target_amount"></span>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/target') }}" class="btn btn-danger btn-sm">Back</a>
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
<script type="text/javascript" src="{{ url('js/master/target-create.js') }}"></script>
@endsection