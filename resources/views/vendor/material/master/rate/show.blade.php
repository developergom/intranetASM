@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Rates Management<small>View Rate</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal">
        		<!-- <div class="form-group" id="parent_id_container">
	                <label for="parent_id" class="col-sm-2 control-label">Package Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="hidden" id="parent_id" value="{{ $rate->parent_id }}">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ ($rate->parent_id!=0) ? $rate->parent->rate_name : 'NOT BELONG TO ANY PACKAGES' }}">
	                    </div>
	                </div>
	            </div> -->
        		<div class="form-group" id="advertise_rate_type_id_container">
	                <label for="advertise_rate_type_id" class="col-sm-2 control-label">Rate Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="hidden" id="advertise_rate_type_id" value="{{ $rate->advertise_rate_type_id }}">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->advertiseratetype->advertise_rate_type_name }}">
	                    </div>
	                </div>
	            </div>
        		<div class="form-group" id="media_id_container">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->media->media_name or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="rate_name_container">
	            	<label for="rate_name" class="col-sm-2 control-label">Rate Name</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" name="rate_name" id="rate_name" class="form-control input-sm" placeholder="Rate Name" autocomplete="off" readonly="true" value="{{ $rate->rate_name or '' }}">
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group" id="width_container">
	            	<label for="width" class="col-sm-2 control-label">Width</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->width or '' }}">
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group" id="length_container">
	            	<label for="length" class="col-sm-2 control-label">Length</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->length or '' }}">
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group" id="unit_id_container">
	                <label for="unit_id" class="col-sm-2 control-label">Unit</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->unit->unit_name or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="studio_id_container">
	                <label for="studio_id" class="col-sm-2 control-label">Studio</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->studio->studio_name or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="duration_container">
	            	<label for="duration" class="col-sm-2 control-label">Duration</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->duration or '' }}">
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group" id="duration_type_container">
	                <label for="duration_type" class="col-sm-2 control-label">Duration Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->duration_type or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="spot_type_container">
	                <label for="spot_type_id" class="col-sm-2 control-label">Spot Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->spottype->spot_type_name or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="gross_rate_container">
	                <label for="gross_rate" class="col-sm-2 control-label">Gross Rate</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ ($rate->gross_rate!=0) ? number_format($rate->gross_rate) : '' }}">
	                    </div>
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_gross_rate"></span>
	                </div>
	            </div>
	            <div class="form-group" id="discount_container">
	                <label for="discount" class="col-sm-2 control-label">Discount</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ ($rate->discount!='') ? number_format($rate->discount) : '' }}">
	                    </div>
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_discount"></span>
	                </div>
	            </div>
	            <div class="form-group" id="nett_rate_container">
	                <label for="nett_rate" class="col-sm-2 control-label">Nett Rate</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ ($rate->nett_rate!='') ? number_format($rate->nett_rate) : '' }}">
	                    </div>
	                </div>	                
	                <div class="col-sm-7">
	                	<span class="badge" id="result_nett_rate"></span>
	                </div>
	            </div>
	            <div class="form-group" id="start_valid_date_container">
	                <label for="start_valid_date" class="col-sm-2 control-label">Start Valid Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="start_valid_date" id="start_valid_date" placeholder="e.g 17/08/1945"  maxlength="10" value="{{ $start_valid_date or '' }}" autocomplete="off" data-mask="00/00/0000" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="end_valid_date_container">
	                <label for="end_valid_date" class="col-sm-2 control-label">End Valid Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="end_valid_date" id="end_valid_date" placeholder="e.g 17/08/1945"  maxlength="10" value="{{ $end_valid_date or '' }}" autocomplete="off" data-mask="00/00/0000" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="cinema_tax_container">
	                <label for="cinema_tax" class="col-sm-2 control-label">Cinema Tax</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ ($rate->cinema_tax) ?  number_format($rate->cinema_tax) : '' }}">
	                    </div>
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_cinema_tax"></span>
	                </div>
	            </div>
	            <div class="form-group" id="paper_id_container">
	                <label for="paper_id" class="col-sm-2 control-label">Paper</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->paper->paper_name or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="color_id_container">
	                <label for="color_id" class="col-sm-2 control-label">Color</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" readonly="true" value="{{ $rate->color->color_name or '' }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/rate') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jquery.price_format.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/rate-create.js') }}"></script>
@endsection