@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Report<small>Generate report</small></h2></div>
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
						                <label for="project_task_type_id">Task Type</label>
						                <select name="project_task_type_id" id="project_task_type_id" class="form-control input-sm selectpicker" data-live-search="true" multiple>
			                                @foreach ($project_task_types as $key => $value)
											    <option value="{{ $value->project_task_type_id }}">{{ $value->project_task_type_name }}</option>
											@endforeach
			                            </select>
						            </div>
						            <div class="form-group">
						                <label for="periode_start">Period Start</label>
					                    <div class="fg-line">
					                        <input type="text" class="form-control input-sm date-picker" name="period_start" id="period_start" placeholder="Period Start e.g 17/08/1945" maxlength="10" value="">
					                    </div>
						            </div>
						            <div class="form-group">
						                <label for="periode_end">Period End</label>
					                    <div class="fg-line">
					                        <input type="text" class="form-control input-sm date-picker" name="period_end" id="period_end" placeholder="Period End e.g 17/08/1945" maxlength="10" value="">
					                    </div>
						            </div>
						            <div class="form-group">
						            	<button id="btn_generate_report" class="btn btn-primary waves-effect">Generate</button>
						            	<button id="btn_clear_report" class="btn btn-danger waves-effect">Clear</button>
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
							        <table id="grid-data-result" class="table table-hover">
							            <thead>
							                <tr>
							                    <th>Project</th>
							                    <th>Task Type</th>
							                    <th>Task Name</th>
							                    <th>Deadline</th>
							                    <th>PIC</th>
							                    <th>Author</th>
							                </tr>
							            </thead>
							            <tbody>
							            </tbody>
							        </table>
							    </div>
							    <div class="row">
							    	<div class="col-md-12"><br/>
							    		<button id="btn_export_report" class="btn btn-success waves-effect">Export</button>
							    	</div>
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
<script src="{{ url('js/grid/report.js') }}"></script>
@endsection