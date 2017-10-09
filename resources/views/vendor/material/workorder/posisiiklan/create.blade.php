@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Posisi Iklan<small>Generate Posisi Iklan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('workorder/posisi_iklan') }}">
        		{{ csrf_field() }}
        		<input type="hidden" id="posisi_iklan_code" name="posisi_iklan_code">
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
	                <label for="view_type" class="col-sm-2 control-label">View Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="view_type" id="view_type" class="selectpicker" data-live-search="true" required="true">
	                        	<option value="print">Print</option>
	                        	<option value="digital">Digital</option>
	                        </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="year_container">
	                <label for="year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="year" id="year" class="selectpicker" data-live-search="true">
	                        	@foreach($years as $year)
	                        		{!! $selected = '' !!}
	                        		@if($thisyear==$year)
	                        			{!! $selected = 'selected' !!}
	                        		@endif
	                        		<option value="{{ $year }}" {{ $selected }}>{{ $year }}</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                    @if ($errors->has('year'))
							<span class="help-block">
								<strong>{{ $errors->first('year') }}</strong>
							</span>
						@endif
	                </div>
	            </div>
	            <div class="form-group" id="month_container">
	                <label for="month" class="col-sm-2 control-label">Month</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="month" id="month" class="selectpicker" data-live-search="true">
	                        	@foreach($months as $month)
	                        		{!! $selected = '' !!}
	                        		@if($thismonth==$month['key'])
	                        			{!! $selected = 'selected' !!}
	                        		@endif
	                        		<option value="{{ $month['key'] }}" {{ $selected }}>{{ $month['values'] }}</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                    @if ($errors->has('month'))
							<span class="help-block">
								<strong>{{ $errors->first('month') }}</strong>
							</span>
						@endif
	                </div>
	            </div>
	            <div class="form-group" id="edition_date_container">
	                <label for="edition_date" class="col-sm-2 control-label">Edition Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control date-picker" name="edition_date" id="edition_date" placeholder="dd/mm/yyyy" maxlength="10" value="{{ date('d/m/Y') }}">
	                    </div>
	                    @if ($errors->has('edition_date'))
							<span class="help-block">
								<strong>{{ $errors->first('edition_date') }}</strong>
							</span>
						@endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="button" id="btn-process" class="btn btn-primary btn-sm waves-effect">Process</button>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12" id="result_container">
	            		
	            	</div>
	            </div>
	            <div class="form-group">
	            	<label for="posisi_iklan_notes" class="col-sm-2 control-label">Notes</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<textarea name="posisi_iklan_notes" id="posisi_iklan_notes" class="form-control input-sm">{{ old('posisi_iklan_notes') }}</textarea>
	            		</div>
						@if ($errors->has('posisi_iklan_notes'))
							<span class="help-block">
								<strong>{{ $errors->first('posisi_iklan_notes') }}</strong>
							</span>
						@endif
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    	<a href="{{ url('workorder/posisi_iklan') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('js/workorder/posisiiklan-create.js') }}"></script>
@endsection