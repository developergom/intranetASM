@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Planner Report<small>Generate planner performance report</small></h2></div>
        <div class="card-body card-padding">
        	<div class="row">
        		<div class="col-md-3">
        			<div role="tabpanel">
			            <ul class="tab-nav" role="tablist">
			                <li class="active"><a href="#filtersection" aria-controls="filtersection" role="tab" data-toggle="tab">Filter</a></li>
			            </ul>
			            <div class="tab-content">
				            <div role="tabpanel" class="tab-pane active" id="filtersection">
				            	<form class="form" role="form" action="javascript:void(0)">
				            		<div class="form-group">
						                <label for="user_id">Planner(s)</label>
						                <select name="user_id" id="user_id" class="form-control input-sm selectpicker" data-live-search="true" multiple>
			                                @foreach ($users as $key => $value)
											    <option value="{{ $value->user_id }}" selected>{{ $value->user_firstname . ' ' . $value->user_lastname . ' (' . $value->user_status . ')' }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="year">Year</label>
						                <select name="year" id="year" class="form-control input-sm selectpicker" data-live-search="true">
			                                @foreach ($years as $key => $value)
											    <option value="{{ $value }}">{{ $value }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						            	<button id="btn_generate_report" class="btn btn-primary waves-effect">Generate</button>
						            	<button id="btn_clear_report" class="btn btn-danger waves-effect">Clear</button>
						            </div>
						            <div class="form-group">
						            	<button id="btn_export_report" class="btn btn-success waves-effect">Export Result</button>
						            </div>
				            	</form>
				            </div>
				        </div>
				    </div>
        		</div>
        		<div class="col-md-9">
        			<div role="tabpanel">
			            <ul class="tab-nav" role="tablist">
			                <li class="active"><a href="#resultsection" aria-controls="resultsection" role="tab" data-toggle="tab">Result</a></li>
			            </ul>
			            <div class="tab-content">
				            <div role="tabpanel" class="tab-pane active" id="resultsection">
				            	<div class="table-responsive">
							        <table id="grid-data-result" class="table table-hover table-striped table-bordered">
							            <thead>
							                <tr>
							                    <th rowspan="3"><center>No</center></th>
							                    <th rowspan="3"><center>Planner Name</center></th>
							                    <th colspan="12"><center>January</center></th>
							                    <th colspan="12"><center>February</center></th>
							                    <th colspan="12"><center>March</center></th>
							                    <th colspan="12"><center>April</center></th>
							                    <th colspan="12"><center>May</center></th>
							                    <th colspan="12"><center>June</center></th>
							                    <th colspan="12"><center>July</center></th>
							                    <th colspan="12"><center>August</center></th>
							                    <th colspan="12"><center>September</center></th>
							                    <th colspan="12"><center>October</center></th>
							                    <th colspan="12"><center>November</center></th>
							                    <th colspan="12"><center>December</center></th>
							                    <th colspan="12"><center>Total in Year</center></th>
							                    <th rowspan="3"><center>Planner Name</center></th>
							                </tr>
							                <tr>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                </tr>
							                <tr>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                </tr>
							            </thead>
							            <tbody>
							            </tbody>
							            <tfoot>
							            	<tr>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                	<th><center>Direct</center></th>
							                	<th><center>Brief</center></th>
							                	<th><center>All</center></th>
							                </tr>
							                <tr>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                	<th colspan="3"><center>Sold</center></th>
							                	<th colspan="3"><center>Not Sold</center></th>
							                	<th colspan="3"><center>On Process</center></th>
							                	<th colspan="3"><center>Total</center></th>
							                </tr>
							                <tr>
							                    <th rowspan="3"><center>No</center></th>
							                    <th rowspan="3"><center>Planner Name</center></th>
							                    <th colspan="12"><center>January</center></th>
							                    <th colspan="12"><center>February</center></th>
							                    <th colspan="12"><center>March</center></th>
							                    <th colspan="12"><center>April</center></th>
							                    <th colspan="12"><center>May</center></th>
							                    <th colspan="12"><center>June</center></th>
							                    <th colspan="12"><center>July</center></th>
							                    <th colspan="12"><center>August</center></th>
							                    <th colspan="12"><center>September</center></th>
							                    <th colspan="12"><center>October</center></th>
							                    <th colspan="12"><center>November</center></th>
							                    <th colspan="12"><center>December</center></th>
							                    <th colspan="12"><center>Total in Year</center></th>
							                    <th rowspan="3"><center>Planner Name</center></th>
							                </tr>
							            </tfoot>
							        </table>
							    </div>
				            </div>
				        </div>
				    </div>
        		</div>
        	</div>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jquery.table2excel.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/report/planner.js') }}"></script>
@endsection