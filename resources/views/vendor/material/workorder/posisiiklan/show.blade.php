@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Posisi Iklan<small>View Posisi Iklan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="posisi_iklan_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" name="posisi_iklan_code" id="posisi_iklan_code" class="form-control input-sm" readonly="true" placeholder="Code" value="{{ $posisiiklan->posisi_iklan_code }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" name="media_name" id="media_name" class="form-control input-sm" readonly="true" placeholder="Media" value="{{ $posisiiklan->media->media_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="view_type" class="col-sm-2 control-label">Type</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="view_type" id="view_type" class="form-control input-sm" readonly="true" placeholder="Type" value="{{ $posisiiklan->posisi_iklan_type }}">
	                    </div>
	                </div>
	            </div>
	        @if($posisiiklan->posisi_iklan_type=='print')
	            <div class="form-group" id="edition_date_container">
	                <label for="edition_date" class="col-sm-2 control-label">Edition Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="edition_date" id="edition_date" class="form-control input-sm" readonly="true" placeholder="Edition Date" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $posisiiklan->posisi_iklan_edition)->format('d/m/Y') }}">
	                    </div>
	                </div>
	            </div>
	        @elseif($posisiiklan->posisi_iklan_type=='digital')
	            <div class="form-group" id="year_container">
	                <label for="year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="year" id="year" class="form-control input-sm" readonly="true" placeholder="Year" value="{{ $posisiiklan->posisi_iklan_year }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group" id="month_container">
	                <label for="month" class="col-sm-2 control-label">Month</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" name="month" id="month" class="form-control input-sm" readonly="true" placeholder="Month" value="{{ $posisiiklan->posisi_iklan_month }}">
	                    </div>
	                </div>
	            </div>
	        @endif
	            <div class="form-group">
	            	<label for="posisi_iklan_notes" class="col-sm-2 control-label">Notes</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			{!! $posisiiklan->posisi_iklan_notes !!}
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12 table-responsive">
	            		<table class="table table-hover">
	            		@if($posisiiklan->posisi_iklan_type=='print')
	            			<thead>
	            				<tr>
	            					<th>BIRO IKLAN</th>
	            					<th>JUDUL IKLAN</th>
	            					<th>INDUSTRI</th>
	            					<th>SALES AGENT</th>
	            					<th>UKURAN</th>
	            					<th>REMARKS</th>
	            					<th>HAL</th>
	            					<th>MATERI</th>
	            					<th>SALES ORDER</th>
	            					<th>NETTO</th>
	            					<th>PPN</th>
	            					<th>JUMLAH</th>
	            				</tr>
	            			</thead>
	            			<tbody>
	            			@foreach($posisiiklan->posisiiklanitems as $item)
	            				<tr>
	            					<td>{{ $item->client->client_name }}</td>
	            					<td>{{ $item->posisi_iklan_item_name }}</td>
	            					<td>{{ $item->industry->industry_name }}</td>
	            					<td>{{ $item->sales->user_firstname . ' ' . $item->sales->user_lastname }}</td>
	            					<td>{{ $item->summaryitem->rate->width . ' x ' . $item->summaryitem->rate->length . ' ' . $item->summaryitem->rate->unit->unit_code }}</td>
	            					<td>{{ $item->summaryitem->summary_item_remarks }}</td>
	            					<td>{{ $item->posisi_iklan_item_page_no }}</td>
	            					<td>{{ $item->posisi_iklan_item_materi }}</td>
	            					<td>{{ $item->posisi_iklan_item_sales_order }}</td>
	            					<td>{{ number_format($item->posisi_iklan_item_nett) }}</td>
	            					<td>{{ number_format($item->posisi_iklan_item_ppn) }}</td>
	            					<td>{{ number_format($item->posisi_iklan_item_total) }}</td>
	            				</tr>
	            			@endforeach
	            			</tbody>
	            		@elseif($posisiiklan->posisi_iklan_type=='digital')
	            			<thead>
	            				<tr>
	            					<th>PERIODE TAYANG</th>
	            					<th>BIRO IKLAN</th>
	            					<th>JUDUL IKLAN</th>
	            					<th>INDUSTRI</th>
	            					<th>SALES AGENT</th>
	            					<th>UKURAN</th>
	            					<th>POSISI</th>
	            					<th>REMARKS</th>
	            					<th>KANAL</th>
	            					<th>ORDER DIGITAL</th>
	            					<th>MATERI</th>
	            					<th>STATUS MATERI</th>
	            					<th>CAPTURE MATERI</th>
	            					<th>SALES ORDER</th>
	            					<th>NETTO</th>
	            					<th>PPN</th>
	            					<th>JUMLAH</th>
	            				</tr>
	            			</thead>
	            			<tbody>
	            			@foreach($posisiiklan->posisiiklanitems as $item)
	            				<tr>
	            					<td>{{ Carbon\Carbon::createFromFormat('Y-m-d', $item->summaryitem->summary_item_period_start)->format('d/m/Y') . ' s/d ' . Carbon\Carbon::createFromFormat('Y-m-d', $item->summaryitem->summary_item_period_end)->format('d/m/Y') }}</td>
	            					<td>{{ $item->client->client_name }}</td>
	            					<td>{{ $item->posisi_iklan_item_name }}</td>
	            					<td>{{ $item->industry->industry_name }}</td>
	            					<td>{{ $item->sales->user_firstname . ' ' . $item->sales->user_lastname }}</td>
	            					<td>{{ $item->summaryitem->rate->width . ' x ' . $item->summaryitem->rate->length . ' ' . $item->summaryitem->rate->unit->unit_code }}</td>
	            					<td>{{ $item->summaryitem->rate->rate_name }}</td>
	            					<td>{{ $item->summaryitem->summary_item_remarks }}</td>
	            					<td>{{ $item->posisi_iklan_item_canal }}</td>
	            					<td>{{ $item->posisi_iklan_item_order_digital }}</td>
	            					<td>{{ $item->posisi_iklan_item_materi }}</td>
	            					<td>{{ $item->posisi_iklan_item_status_materi }}</td>
	            					<td>{{ $item->posisi_iklan_item_capture_materi }}</td>
	            					<td>{{ $item->posisi_iklan_item_sales_order }}</td>
	            					<td>{{ number_format($item->posisi_iklan_item_nett) }}</td>
	            					<td>{{ number_format($item->posisi_iklan_item_ppn) }}</td>
	            					<td>{{ number_format($item->posisi_iklan_item_total) }}</td>
	            				</tr>
	            			@endforeach
	            			</tbody>
	            		@endif
	            		</table>
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
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
@endsection

@section('customjs')
@endsection