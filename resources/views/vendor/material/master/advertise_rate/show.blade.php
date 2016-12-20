@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Rates Management<small>View Advertise Rate</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" value="{{ $advertiserate->media->media_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_position_id" class="col-sm-2 control-label">Position</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" value="{{ $advertiserate->advertiseposition->advertise_position_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_id" class="col-sm-2 control-label">Size</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" value="{{ $advertiserate->advertisesize->advertise_size_name . ' ' . $advertiserate->advertisesize->advertise_size_width . ' x ' . $advertiserate->advertisesize->advertise_size_length . ' ' . $advertiserate->advertisesize->unit->unit_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="paper_id" class="col-sm-2 control-label">Paper</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" value="{{ $advertiserate->paper->paper_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_code" id="advertise_rate_code" placeholder="Advertise Rate Code" required="true" maxlength="15" value="{{ $advertiserate->advertise_rate_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_startdate" class="col-sm-2 control-label">Start Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="advertise_rate_startdate" id="advertise_rate_startdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $advertise_rate_startdate }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_enddate" class="col-sm-2 control-label">End Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="advertise_rate_enddate" id="advertise_rate_enddate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $advertise_rate_enddate }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_normal" class="col-sm-2 control-label">Normal Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_normal_tmp" id="advertise_rate_normal_tmp" placeholder="Normal Rate" required="true" maxlength="15" value="{{ $advertiserate->advertise_rate_normal }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_discount" class="col-sm-2 control-label">Discount Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_discount_tmp" id="advertise_rate_discount_tmp" placeholder="Discount Rate" maxlength="15" value="{{ $advertiserate->advertise_rate_discount }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/advertiserate') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/jquery.price_format.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/advertiserate-create.js') }}"></script>
@endsection