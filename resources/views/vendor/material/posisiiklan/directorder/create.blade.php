@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Direct Order<small>Create New Direct Order</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('posisi-iklan/direct-order') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="summary_item_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_title" id="summary_item_title" placeholder="Title" required="true" maxlength="100" value="{{ old('summary_item_title') }}">
	                    </div>
	                    @if ($errors->has('summary_item_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_id" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id" id="client_id" class="selectpicker" data-live-search="true" required="true">
                            </select>
	                    </div>
	                    @if ($errors->has('client_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_id') }}</strong>
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
                                @foreach ($industry as $row)
                                	{!! $selected = '' !!}
                                	@if($row->industry_id==old('industry_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name  }}</option>
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
	                <label for="rate_id" class="col-sm-2 control-label">Rate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="rate_id" id="rate_id" class="selectpicker" data-live-search="true" required="true">
                            </select>
	                    </div>
	                    @if ($errors->has('rate_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('rate_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="media_name" class="col-sm-2 control-label">Media</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<input type="text" id="media_name" class="form-control input-sm" readonly="true" placeholder="Media Name" value="">
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_period_start" class="col-sm-2 control-label">Period Start/Edition Date</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <div class="input-group form-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                <div class="dtp-container fg-line">
                                    <input type="text" class="form-control date-picker" name="summary_item_period_start" id="summary_item_period_start" placeholder="dd/mm/yyyy" required="true" maxlength="10" value="{{ old('summary_item_period_start') }}">
                                </div>
                            </div>
	                    </div>
	                    @if ($errors->has('summary_item_period_start'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_period_start') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_period_end" class="col-sm-2 control-label">Period End (For Digital)</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <div class="input-group form-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                <div class="dtp-container fg-line">
                                    <input type="text" class="form-control date-picker" name="summary_item_period_end" id="summary_item_period_end" placeholder="dd/mm/yyyy (Not Required)" maxlength="10" value="{{ old('summary_item_period_end') }}">
                                </div>
                            </div>
	                    </div>
	                    @if ($errors->has('summary_item_period_end'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_period_end') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="omzet_type" class="col-sm-2 control-label">Omzet Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="omzet_type_id" id="omzet_type_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($omzettypes as $row)
                                	{!! $selected = '' !!}
                                	@if($row->omzet_type_id==old('omzet_type_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->omzet_type_id }}" {{ $selected }}>{{ $row->omzet_type_name  }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('omzet_type_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('omzet_type_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_type" class="col-sm-2 control-label">Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="summary_item_type" id="summary_item_type" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($summary_item_types as $row)
                                	{!! $selected = '' !!}
                                	@if($row==old('summary_item_type'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row }}" {{ $selected }}>{{ $row  }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('summary_item_type'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_type') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_insertion" class="col-sm-2 control-label">Insertion</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="number" class="form-control input-sm" name="summary_item_insertion" id="summary_item_insertion"  required="true" placeholder="0" maxlength="100" value="{{ old('summary_item_insertion') }}">
	                    </div>
	                    @if ($errors->has('summary_item_insertion'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_insertion') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_gross" class="col-sm-2 control-label">Gross Rate</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_gross" id="summary_item_gross" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_gross') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('summary_item_gross'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_gross') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		<span class="badge" id="format_summary_item_gross">0</span>
	               	</div>
	               	<label for="summary_item_disc" class="col-sm-2 control-label">Disc (%)</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_disc" id="summary_item_disc" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_disc') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('summary_item_disc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_disc') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		
	               	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_nett" class="col-sm-2 control-label">Nett Rate</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_nett" id="summary_item_nett" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_nett') }}">
	                    </div>
	                    @if ($errors->has('summary_item_nett'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_nett') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		<span class="badge" id="format_summary_item_nett">0</span>
	               	</div>
	               	<label for="summary_item_po" class="col-sm-2 control-label">PO</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_po" id="summary_item_po" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_po') }}">
	                    </div>
	                    @if ($errors->has('summary_item_po'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_po') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		<span class="badge" id="format_summary_item_po">0</span>
	               	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_ppn" class="col-sm-2 control-label">PPN</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_ppn" id="summary_item_ppn" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_ppn') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('summary_item_ppn'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_ppn') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		<span class="badge" id="format_summary_item_ppn">0</span>
	               	</div>
	               	<label for="summary_item_internal_omzet" class="col-sm-2 control-label">Internal Omzet</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_internal_omzet" id="summary_item_internal_omzet" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_internal_omzet') }}">
	                    </div>
	                    @if ($errors->has('summary_item_internal_omzet'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_internal_omzet') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		<span class="badge" id="format_summary_item_internal_omzet">0</span>
	               	</div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_total" class="col-sm-2 control-label">Total</label>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_total" id="summary_item_total" placeholder="0" required="true" maxlength="100" value="{{ old('summary_item_total') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('summary_item_total'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_total') }}</strong>
			                </span>
			            @endif
	                </div>
	               	<div class="col-sm-2">
	               		<span class="badge" id="format_summary_item_total">0</span>
	               	</div>
	               	<div class="col-sm-6">
	               		<button type="button" class="btn btn-warning">Recalculate</button>
	               	</div>
	            </div>
	            <hr/>
	            <div class="form-group">
	                <label for="page_no" class="col-sm-2 control-label">Halaman</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="page_no" id="page_no" placeholder="Halaman (Not Required)" maxlength="100" value="{{ old('page_no') }}">
	                    </div>
	                    @if ($errors->has('page_no'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('page_no') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_canal" class="col-sm-2 control-label">Kanal</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_canal" id="summary_item_canal" placeholder="Kanal (Not Required)" maxlength="100" value="{{ old('summary_item_canal') }}">
	                    </div>
	                    @if ($errors->has('summary_item_canal'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_canal') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_order_digital" class="col-sm-2 control-label">Order Digital</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_order_digital" id="summary_item_order_digital" placeholder="Order Digital (Not Required)" maxlength="100" value="{{ old('summary_item_order_digital') }}">
	                    </div>
	                    @if ($errors->has('summary_item_order_digital'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_order_digital') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_materi" class="col-sm-2 control-label">Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_materi" id="summary_item_materi" placeholder="Materi (Not Required)" maxlength="100" value="{{ old('summary_item_materi') }}">
	                    </div>
	                    @if ($errors->has('summary_item_materi'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_materi') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_status_materi" class="col-sm-2 control-label">Status Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_status_materi" id="summary_item_status_materi" placeholder="Status Materi (Not Required)" maxlength="100" value="{{ old('summary_item_status_materi') }}">
	                    </div>
	                    @if ($errors->has('summary_item_status_materi'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_status_materi') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_capture_materi" class="col-sm-2 control-label">Capture Materi</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_capture_materi" id="summary_item_capture_materi" placeholder="Capture Materi (Not Required)" maxlength="100" value="{{ old('summary_item_capture_materi') }}">
	                    </div>
	                    @if ($errors->has('summary_item_capture_materi'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_capture_materi') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_sales_order" class="col-sm-2 control-label">Sales Order</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_sales_order" id="summary_item_sales_order" placeholder="Sales Order (Not Required)" maxlength="100" value="{{ old('summary_item_sales_order') }}">
	                    </div>
	                    @if ($errors->has('summary_item_sales_order'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_sales_order') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <hr/>
	            <div class="form-group">
	                <label for="summary_item_viewed" class="col-sm-2 control-label">Status</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="summary_item_viewed" id="summary_item_viewed" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($summary_item_viewed as $row)
                                	{!! $selected = '' !!}
                                	@if($row==old('summary_item_viewed'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row }}" {{ $selected }}>{{ $row  }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('summary_item_viewed'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_viewed') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="summary_item_remarks" class="col-sm-2 control-label">Remarks</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="summary_item_remarks" id="summary_item_remarks" placeholder="Remarks (Not Required)" maxlength="100" value="{{ old('summary_item_remarks') }}">
	                    </div>
	                    @if ($errors->has('summary_item_remarks'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('summary_item_remarks') }}</strong>
			                </span>
			            @endif
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