@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Report<small>Generate inventory report</small></h2></div>
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
						                <label for="media_id">Media(s)</label>
						                <select name="media_id" id="media_id" class="form-control input-sm selectpicker" data-size="5" data-live-search="true" multiple>
			                                @foreach ($medias as $key => $value)
											    <option value="{{ $value->media_id }}">{{ $value->media_name }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="industry_id">Industry(s)</label>
						                <select name="industry_id" id="industry_id" class="form-control input-sm selectpicker" data-size="5" data-live-search="true" multiple>
			                                @foreach ($industries as $key => $value)
											    <option value="{{ $value->industry_id }}">{{ $value->industry_name }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="sell_period_id">Sell Period Month(s)</label>
						                <select name="sell_period_id" id="sell_period_id" class="form-control input-sm selectpicker" data-size="5" data-live-search="true" multiple>
			                                @foreach ($sellperiods as $key => $value)
											    <option value="{{ $value->sell_period_id }}">{{ $value->sell_period_month_name }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="sell_period_year">Sell Period Year(s)</label>
						                <select name="sell_period_year" id="sell_period_year" class="form-control input-sm selectpicker" data-size="5" data-live-search="true" multiple>
			                                @foreach ($years as $key => $value)
											    <option value="{{ $value }}">{{ $value }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="sell_periode_start">Offer Period Start</label>
					                    <div class="fg-line">
					                        <input type="text" class="form-control input-sm date-picker" name="offer_period_start" id="offer_period_start" placeholder="Offer Period Start e.g 17/08/1945" maxlength="10" value="">
					                    </div>
						            </div>
						            <div class="form-group">
						                <label for="sell_periode_end">Offer Period End</label>
					                    <div class="fg-line">
					                        <input type="text" class="form-control input-sm date-picker" name="offer_period_end" id="offer_period_end" placeholder="Offer Period End e.g 17/08/1945" maxlength="10" value="">
					                    </div>
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
							        <table id="grid-data-result" class="table table-hover table-bordered">
							            <thead>
							                <tr>
							                    <th rowspan="2">No</th>
							                    <th rowspan="2">Program</th>
							                    <th rowspan="2">Title</th>
							                    <th rowspan="2">Desc</th>
							                    <th rowspan="2">Sell Period</th>
							                    <th rowspan="2">Media</th>
							                    <th rowspan="2">Planner Created</th>
							                    <th colspan="4"><center>Offer</center></th>
							                    <th rowspan="2">Proposal No</th>
							                    <th rowspan="2">Sales Agent</th>
							                    <th rowspan="2">Industry</th>
							                    <th rowspan="2">Brand</th>
							                    <th rowspan="2">Status</th>
							                    <th colspan="4"><center>Deal</center></th>
							                </tr>
							                <tr>
							                	<th>Cost</th>
							                    <th>Media Cost Print</th>
							                    <th>Media Cost Other</th>
							                    <th>Total Offering</th>
							                    <th>Cost</th>
							                    <th>Media Cost Print</th>
							                    <th>Media Cost Other</th>
							                    <th>Total Deal Cost</th>
							                </tr>
							            </thead>
							            <tbody>
							            </tbody>
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
<script src="{{ url('js/report/inventory.js') }}"></script>
@endsection