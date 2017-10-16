@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Posisi Iklan Item Task<small>Take Item Task</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('posisi-iklan/item_task/take/' . $summaryitem->summary_item_id) }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" name="media_name" id="media_name" class="form-control input-sm" readonly="true" placeholder="Media" value="{{ $summaryitem->rate->media->media_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="edition_date_container">
	                <label for="edition_date" class="col-sm-2 control-label">Edition Date/Start Period</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="edition_date" id="edition_date" class="form-control input-sm" readonly="true" placeholder="Edition Date" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $summaryitem->summary_item_period_start)->format('d/m/Y') }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="edition_date_container">
	                <label for="end_period" class="col-sm-2 control-label">End Period</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="end_period" id="end_period" class="form-control input-sm" readonly="true" placeholder="Edition Date" value="{{ ($summaryitem->summary_item_period_end=='0000-00-00') ? '-' : Carbon\Carbon::createFromFormat('Y-m-d', $summaryitem->summary_item_period_end)->format('d/m/Y') }}">
	                    </div>
	                </div>
	            </div>
	        	<hr/>
	        	<div class="form-group">
	                <label for="client_name" class="col-sm-2 control-label">Biro Iklan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="client_name" id="client_name" class="form-control input-sm" readonly="true" placeholder="Biro Iklan" value="{{ $summaryitem->client->client_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="posisi_iklan_item_name" class="col-sm-2 control-label">Judul Iklan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="posisi_iklan_item_name" id="posisi_iklan_item_name" class="form-control input-sm" readonly="true" placeholder="Biro Iklan" value="{{ $summaryitem->summary_item_title }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_name" class="col-sm-2 control-label">Industri</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="industry_name" id="industry_name" class="form-control input-sm" readonly="true" placeholder="Industri" value="{{ $summaryitem->industry->industry_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="sales_agent" class="col-sm-2 control-label">Sales Agent</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="sales_agent" id="sales_agent" class="form-control input-sm" readonly="true" placeholder="Sales Agent" value="{{ $summaryitem->sales->user_firstname . ' ' . $summaryitem->sales->user_lastname }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="ukuran" class="col-sm-2 control-label">Ukuran</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="ukuran" id="ukuran" class="form-control input-sm" readonly="true" placeholder="Ukuran" value="{{ $summaryitem->rate->width . ' x ' . $summaryitem->rate->length . ' ' . $summaryitem->rate->unit->unit_code }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="remarks" class="col-sm-2 control-label">Remarks</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="remarks" id="remarks" class="form-control input-sm" readonly="true" placeholder="Remarks" value="{{ $summaryitem->summary_item_remarks }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="materi" class="col-sm-2 control-label">Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="materi" id="materi" class="form-control input-sm" readonly="true" placeholder="Materi" value="{{ $summaryitem->summary_item_materi }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="posisi_iklan_item_page_no" class="col-sm-2 control-label">Halaman</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="posisi_iklan_item_page_no" id="posisi_iklan_item_page_no" class="form-control input-sm" readonly="true" placeholder="Materi" value="{{ $summaryitem->page_no }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="canal" class="col-sm-2 control-label">Kanal</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="canal" id="canal" class="form-control input-sm" readonly="true" placeholder="Kanal" value="{{ $summaryitem->summary_item_canal }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="order_digital" class="col-sm-2 control-label">Order Digital</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="order_digital" id="order_digital" class="form-control input-sm" readonly="true" placeholder="Order Digital" value="{{ $summaryitem->summary_item_order_digital }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="status_materi" class="col-sm-2 control-label">Status Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="status_materi" id="status_materi" class="form-control input-sm" readonly="true" placeholder="Status Materi" value="{{ $summaryitem->summary_item_status_materi }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="capture_materi" class="col-sm-2 control-label">Capture Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="capture_materi" id="capture_materi" class="form-control input-sm" readonly="true" placeholder="Capture Materi" value="{{ $summaryitem->summary_item_capture_materi }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Take this task</button>
                    	<a href="{{ url('posisi-iklan/item_task') }}" class="btn btn-danger btn-sm">Back</a>
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
@endsection