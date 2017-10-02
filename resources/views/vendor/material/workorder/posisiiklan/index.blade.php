@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Posisi Iklan<small>View</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<select name="media_id" id="media_id" class="selectpicker" data-live-search="true" required="true">
	                        	@foreach($medias as $media)
	                        		{!! $selected = '' !!}
	                        		@if($media->media_id==old('media_id'))
	                        			{!! $selected = 'selected' !!}
	                        		@endif
	                        		<option value="{{ $media->media_id }}" {{ $selected }}>{{ $media->media_name }}</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="year" id="year" class="selectpicker" data-live-search="true" required="true">
	                        	@foreach($years as $year)
	                        		{!! $selected = '' !!}
	                        		@if($thisyear==$year)
	                        			{!! $selected = 'selected' !!}
	                        		@endif
	                        		<option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="month" class="col-sm-2 control-label">Month</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="month" id="month" class="selectpicker" data-live-search="true" required="true">
	                        	@foreach($months as $month)
	                        		{!! $selected = '' !!}
	                        		@if($thismonth==$month['key'])
	                        			{!! $selected = 'selected' !!}
	                        		@endif
	                        		<option value="{{ $month['key'] }}" {{ $selected }}>{{ $month['values'] }}</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="view_type" class="col-sm-2 control-label">View Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="view_type" id="view_type" class="selectpicker" data-live-search="true" required="true">
	                        	<option value="per_date">Per Date</option>
	                        	<option value="per_month">Per Month</option>
	                        </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="button" id="btn-process" class="btn btn-primary btn-sm waves-effect">Process</button>
	                    <a href="javascript:void(0)" class="btn btn-danger btn-sm waves-effect">Reset</a>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12" id="result_container">
	            		
	            	</div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('js/workorder/posisiiklan.js') }}"></script>
@endsection