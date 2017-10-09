@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Posisi Iklan Item Task<small>View Item Task</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="posisi_iklan_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" name="posisi_iklan_code" id="posisi_iklan_code" class="form-control input-sm" readonly="true" placeholder="Code" value="{{ $posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_code }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" name="media_name" id="media_name" class="form-control input-sm" readonly="true" placeholder="Media" value="{{ $posisiiklanitemtask->posisiiklanitem->posisiiklan->media->media_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="view_type" class="col-sm-2 control-label">Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="view_type" id="view_type" class="form-control input-sm" readonly="true" placeholder="Type" value="{{ $posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_type }}">
	                    </div>
	                </div>
	            </div>
	        @if($posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_type=='print')
	            <div class="form-group" id="edition_date_container">
	                <label for="edition_date" class="col-sm-2 control-label">Edition Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="edition_date" id="edition_date" class="form-control input-sm" readonly="true" placeholder="Edition Date" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_edition)->format('d/m/Y') }}">
	                    </div>
	                </div>
	            </div>
	        @elseif($posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_type=='digital')
	            <div class="form-group" id="year_container">
	                <label for="year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="year" id="year" class="form-control input-sm" readonly="true" placeholder="Year" value="{{ $posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_year }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="month_container">
	                <label for="month" class="col-sm-2 control-label">Month</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="month" id="month" class="form-control input-sm" readonly="true" placeholder="Month" value="{{ $posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_month }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="periode_tayang" class="col-sm-2 control-label">Periode Tayang</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="periode_tayang" id="periode_tayang" class="form-control input-sm" readonly="true" placeholder="Materi" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $posisiiklanitemtask->posisiiklanitem->summaryitem->summary_item_period_start)->format('d/m/Y') . ' s/d ' . Carbon\Carbon::createFromFormat('Y-m-d', $posisiiklanitemtask->posisiiklanitem->summaryitem->summary_item_period_end)->format('d/m/Y') }}">
	                    </div>
	                </div>
	            </div>
	        @endif
	        	<hr/>
	        	<div class="form-group">
	                <label for="client_name" class="col-sm-2 control-label">Biro Iklan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="client_name" id="client_name" class="form-control input-sm" readonly="true" placeholder="Biro Iklan" value="{{ $posisiiklanitemtask->posisiiklanitem->client->client_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="posisi_iklan_item_name" class="col-sm-2 control-label">Judul Iklan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="posisi_iklan_item_name" id="posisi_iklan_item_name" class="form-control input-sm" readonly="true" placeholder="Biro Iklan" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_name" class="col-sm-2 control-label">Industri</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="industry_name" id="industry_name" class="form-control input-sm" readonly="true" placeholder="Industri" value="{{ $posisiiklanitemtask->posisiiklanitem->industry->industry_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="sales_agent" class="col-sm-2 control-label">Sales Agent</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="sales_agent" id="sales_agent" class="form-control input-sm" readonly="true" placeholder="Sales Agent" value="{{ $posisiiklanitemtask->posisiiklanitem->sales->user_firstname . ' ' . $posisiiklanitemtask->posisiiklanitem->sales->user_lastname }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="ukuran" class="col-sm-2 control-label">Ukuran</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="ukuran" id="ukuran" class="form-control input-sm" readonly="true" placeholder="Ukuran" value="{{ $posisiiklanitemtask->posisiiklanitem->summaryitem->rate->width . ' x ' . $posisiiklanitemtask->posisiiklanitem->summaryitem->rate->length . ' ' . $posisiiklanitemtask->posisiiklanitem->summaryitem->rate->unit->unit_code }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="remarks" class="col-sm-2 control-label">Remarks</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="remarks" id="remarks" class="form-control input-sm" readonly="true" placeholder="Remarks" value="{{ $posisiiklanitemtask->posisiiklanitem->summaryitem->summary_item_remarks }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="materi" class="col-sm-2 control-label">Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="materi" id="materi" class="form-control input-sm" readonly="true" placeholder="Materi" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_materi }}">
	                    </div>
	                </div>
	            </div>
            @if($posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_type=='print')
	            <div class="form-group">
	                <label for="posisi_iklan_item_page_no" class="col-sm-2 control-label">Halaman</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="posisi_iklan_item_page_no" id="posisi_iklan_item_page_no" class="form-control input-sm" readonly="true" placeholder="Materi" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_page_no }}">
	                    </div>
	                </div>
	            </div>
	        @elseif($posisiiklanitemtask->posisiiklanitem->posisiiklan->posisi_iklan_type=='digital')
	            <div class="form-group">
	                <label for="canal" class="col-sm-2 control-label">Kanal</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="canal" id="canal" class="form-control input-sm" readonly="true" placeholder="Kanal" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_canal }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="order_digital" class="col-sm-2 control-label">Order Digital</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="order_digital" id="order_digital" class="form-control input-sm" readonly="true" placeholder="Order Digital" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_order_digital }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="status_materi" class="col-sm-2 control-label">Status Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="status_materi" id="status_materi" class="form-control input-sm" readonly="true" placeholder="Status Materi" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_status_materi }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="capture_materi" class="col-sm-2 control-label">Capture Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="capture_materi" id="capture_materi" class="form-control input-sm" readonly="true" placeholder="Capture Materi" value="{{ $posisiiklanitemtask->posisiiklanitem->posisi_iklan_item_capture_materi }}">
	                    </div>
	                </div>
	            </div>
	        @endif
	        	<hr/>
	        	<div class="form-group">
	                <label for="pic" class="col-sm-2 control-label">PIC</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="pic" id="pic" class="form-control input-sm" readonly="true" placeholder="PIC" value="{{ $posisiiklanitemtask->_pic->user_firstname . ' ' . $posisiiklanitemtask->_pic->user_lastname }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="status" class="col-sm-2 control-label">Status</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="status" id="status" class="form-control input-sm" readonly="true" placeholder="Status" value="{{ $posisiiklanitemtask->posisi_iklan_item_task_status }}">
	                    </div>
	                </div>
	            </div>
	        @if($posisiiklanitemtask->posisi_iklan_item_task_status=='FINISHED')
	            <div class="form-group">
	                <label for="finish_time" class="col-sm-2 control-label">Finished Time</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="finish_time" id="finish_time" class="form-control input-sm" readonly="true" placeholder="Finished Time" value="{{ $posisiiklanitemtask->posisi_iklan_item_task_finish_time }}">
	                    </div>
	                </div>
	            </div>
	        @endif
	        	<div class="form-group">
	                <label for="notes" class="col-sm-2 control-label">Notes</label>
	                <div class="col-sm-10">
	                    {!! $posisiiklanitemtask->posisi_iklan_item_task_notes !!}
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
                    	<a href="{{ url('workorder/posisi_iklan_item_task') }}" class="btn btn-danger btn-sm">Back</a>
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