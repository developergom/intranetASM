@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Agenda Report<small>Generate agenda report</small></h2></div>
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
						                <label for="sales_agent">Sales Agent(s)</label>
						                <select name="sales_agent" id="sales_agent" class="form-control input-sm selectpicker" data-size="5" data-live-search="true" multiple>
			                                @foreach ($sales_agent as $key => $value)
											    <option value="{{ $value->user_id }}">{{ $value->user_firstname . ' ' . $value->user_lastname }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="agenda_type">Agenda Type(s)</label>
						                <select name="agenda_type" id="agenda_type" class="form-control input-sm selectpicker" data-size="5" data-live-search="true" multiple>
			                                @foreach ($agenda_type as $key => $value)
											    <option value="{{ $value->agenda_type_id }}">{{ $value->agenda_type_name }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="agenda_start_date">Agenda Start Date</label>
					                    <div class="fg-line">
					                        <input type="text" class="form-control input-sm date-picker" name="agenda_start_date" id="agenda_start_date" placeholder="Agenda Start Date e.g 17/08/1945" maxlength="10" value="">
					                    </div>
						            </div>
						            <div class="form-group">
						                <label for="agenda_end_date">Agenda End Date</label>
					                    <div class="fg-line">
					                        <input type="text" class="form-control input-sm date-picker" name="agenda_end_date" id="agenda_end_date" placeholder="Agenda End Date e.g 17/08/1945" maxlength="10" value="">
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
								            	<th>No</th>
								            	<th>Agenda ID</th>
								            	<th>Agenda Type</th>
								            	<th>Date</th>
								            	<th>Description</th>
								            	<th>Status</th>
								            	<th>Meeting Time</th>
								            	<th>Report Time</th>
								            	<th>Report Description</th>
								            	<th>Sales Agent</th>
								            	<th>Client Name</th>
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
<script src="{{ url('js/report/agenda.js') }}"></script>
@endsection