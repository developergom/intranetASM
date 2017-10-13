@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Direct Order<small>View Direct Order</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="summary_item_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_title" id="summary_item_title" placeholder="Title" required="true" maxlength="100" value="{{ $summaryitem->summary_item_title }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_id" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input name="client_name" class="form-control input-sm" placeholder="Client Name" value="{{ $summaryitem->client->client_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
        		<div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input name="industry_name" class="form-control input-sm" placeholder="Industry Name" value="{{ $summaryitem->industry->industry_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="rate_id" class="col-sm-2 control-label">Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input name="rate_name" class="form-control input-sm" placeholder="Rate Name" value="{{ $summaryitem->rate->rate_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="media_name" class="col-sm-2 control-label">Media</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" id="media_name" class="form-control input-sm" readonly="true" placeholder="Media Name" value="{{ $summaryitem->rate->media->media_name }}">
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_period_start" class="col-sm-2 control-label">Period Start/Edition Date</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input name="summary_item_period_start" class="form-control input-sm" placeholder="dd/mm/yyyy" value="{{ $summary_item_period_start }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_period_end" class="col-sm-2 control-label">Period End (For Digital)</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input name="summary_item_period_end" class="form-control input-sm" placeholder="dd/mm/yyyy" value="{{ $summary_item_period_end }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="omzet_type" class="col-sm-2 control-label">Omzet Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input name="omzet_type" class="form-control input-sm" placeholder="Omzet Type" value="{{ $summaryitem->omzettype->omzet_type_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_type" class="col-sm-2 control-label">Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input name="summary_item_type" class="form-control input-sm" placeholder="dd/mm/yyyy" value="{{ $summaryitem->summary_item_type }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_insertion" class="col-sm-2 control-label">Insertion</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="number" class="form-control input-sm" name="summary_item_insertion" id="summary_item_insertion"  required="true" placeholder="0" maxlength="100" value="{{ $summaryitem->summary_item_insertion }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_gross" class="col-sm-2 control-label">Gross Rate</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_gross" id="summary_item_gross" placeholder="0" required="true" maxlength="100" value="{{ number_format($summaryitem->summary_item_gross) }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               		
	               	</div>
	               	<label for="summary_item_disc" class="col-sm-2 control-label">Disc (%)</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_disc" id="summary_item_disc" placeholder="0" required="true" maxlength="100" value="{{ $summaryitem->summary_item_disc }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               		
	               	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_nett" class="col-sm-2 control-label">Nett Rate</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_nett" id="summary_item_nett" placeholder="0" required="true" maxlength="100" value="{{ number_format($summaryitem->summary_item_nett) }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               	</div>
	               	<label for="summary_item_po" class="col-sm-2 control-label">PO</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_po" id="summary_item_po" placeholder="0" required="true" maxlength="100" value="{{ number_format($summaryitem->summary_item_po) }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               		
	               	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_ppn" class="col-sm-2 control-label">PPN</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_ppn" id="summary_item_ppn" placeholder="0" required="true" maxlength="100" value="{{ number_format($summaryitem->summary_item_ppn) }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               		
	               	</div>
	               	<label for="summary_item_internal_omzet" class="col-sm-2 control-label">Internal Omzet</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_internal_omzet" id="summary_item_internal_omzet" placeholder="0" required="true" maxlength="100" value="{{ number_format($summaryitem->summary_item_internal_omzet) }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               		
	               	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_total" class="col-sm-2 control-label">Total</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_total" id="summary_item_total" placeholder="0" required="true" maxlength="100" value="{{ number_format($summaryitem->summary_item_total) }}" readonly="true">
	                    </div>
	                </div>
	               	<div class="col-sm-2">
	               	</div>
	               	<div class="col-sm-6">
	               	
	               	</div>
	            </div>
	            <hr/>
	            <div class="form-group">
	                <label for="page_no" class="col-sm-2 control-label">Halaman</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="page_no" id="page_no" placeholder="Halaman (Not Required)" maxlength="100" value="{{ $summaryitem->page_no }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_canal" class="col-sm-2 control-label">Kanal</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_canal" id="summary_item_canal" placeholder="Kanal (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_canal }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_order_digital" class="col-sm-2 control-label">Order Digital</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_order_digital" id="summary_item_order_digital" placeholder="Order Digital (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_order_digital }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_materi" class="col-sm-2 control-label">Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_materi" id="summary_item_materi" placeholder="Materi (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_materi }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_status_materi" class="col-sm-2 control-label">Status Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_status_materi" id="summary_item_status_materi" placeholder="Status Materi (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_status_materi }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_capture_materi" class="col-sm-2 control-label">Capture Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_capture_materi" id="summary_item_capture_materi" placeholder="Capture Materi (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_capture_materi }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_sales_order" class="col-sm-2 control-label">Sales Order</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_sales_order" id="summary_item_sales_order" placeholder="Sales Order (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_sales_order }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <hr/>
	            <div class="form-group">
	                <label for="summary_item_viewed" class="col-sm-2 control-label">Status</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" name="summary_item_viewed" class="form-control input-sm" value="{{ $summaryitem->summary_item_viewed }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_remarks" class="col-sm-2 control-label">Remarks</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_remarks" id="summary_item_remarks" placeholder="Remarks (Not Required)" maxlength="100" value="{{ $summaryitem->summary_item_remarks }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('posisi-iklan/direct-order') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/posisiiklan/directorder-create.js') }}"></script>
@endsection