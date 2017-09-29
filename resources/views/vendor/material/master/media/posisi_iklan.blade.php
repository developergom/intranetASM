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
	                    	<input type="hidden" name="media_id" id="media_id" value="{{ $media->media_id }}">
	                        <input type="text" class="form-control input-sm" name="media_name" id="_media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ $media->media_name }}" readonly="true">
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
	            	<div class="col-sm-12">
	            		
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="button" id="btn-process" class="btn btn-primary btn-sm waves-effect">Process</button>
	                    <a href="{{ url('master/media') }}" class="btn btn-danger btn-sm waves-effect">Back</a>
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
<script type="text/javascript">
$(document).ready(function(){
	$('#btn-process').click(function(){
		var media_id = $("#media_id").val();
		var year = $("#year").val();
		var month = $("#month").val();

		$.ajax({
			url: base_url + 'workorder/summary/api/generatePosisiIklan',
			dataType: 'json',
			type: 'POST',
			data: {
				'media_id': media_id,
				'year': year,
				'month': month,
				'_token': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response) {
				console.log(response);
				var html = '';
				$.each(response, function(key, value){
					html = (key+1) + ' | ' + value.client_name + ' | ' + value.industry_name + ' | ' + value.rate_name + ' | ' + value.user_firstname + ' ' + value.user_lastname + ' | ' + value.width + 'x' + value.length + ' ' + value.unit_name + ' | ' + value.page_no + ' | ' + value.summary_item_gross;
					console.log(html);
				});
			}
		})
	});
});
</script>
@endsection