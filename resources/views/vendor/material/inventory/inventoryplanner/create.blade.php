@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Planner<small>Create New Inventory Planner</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('inventory/inventoryplanner') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="inventory_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="inventory_type_id" id="inventory_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($inventory_types as $row)
	        						{!! $selected = '' !!}
                                	@if(old('inventory_type_id')==$row->inventory_type_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->inventory_type_id }}" {{ $selected }}>{{ $row->inventory_type_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('inventory_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('inventory_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="inventory_planner_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_title" id="inventory_planner_title" placeholder="Inventory Planner Title" required="true" maxlength="100" value="{{ old('inventory_planner_title') }}">
	                    </div>
	                    @if ($errors->has('inventory_planner_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="inventory_planner_desc" id="inventory_planner_desc" class="form-control input-sm" placeholder="Description">{{ old('inventory_planner_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('inventory_planner_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="implementation_id" class="col-sm-2 control-label">Implementation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="implementation_id[]" id="implementation_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($implementations as $row)
                                	{!! $selected = '' !!}
                                	@if(old('implementation_id'))
	                                	@foreach (old('implementation_id') as $key => $value)
	                                		@if($value==$row->implementation_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->implementation_id }}" {{ $selected }}>{{ $row->implementation_month_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('implementation_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('implementation_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="inventory_planner_year" id="inventory_planner_year" placeholder="e.g 1945" required="true" maxlength="4" value="{{ old('inventory_planner_year') }}" autocomplete="off" data-mask="0000">
	                    </div>
	                    @if ($errors->has('inventory_planner_year'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_year') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="inventory_planner_deadline" id="inventory_planner_deadline" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('inventory_planner_deadline') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('inventory_planner_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@if(old('media_id'))
	                                	@foreach (old('media_id') as $key => $value)
	                                		@if($value==$row->media_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_id" class="col-sm-2 control-label">Action Plan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="action_plan_id[]" id="action_plan_id" class="selectpicker" data-live-search="true" multiple>
                            </select>
	                    </div>
	                    @if ($errors->has('action_plan_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_id" class="col-sm-2 control-label">Event Plan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="event_plan_id[]" id="event_plan_id" class="selectpicker" data-live-search="true" multiple>
                            </select>
	                    </div>
	                    @if ($errors->has('event_plan_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="dropzone" id="uploadFileArea">
	                        	
	                        </div>
	                    </div>
	                    <span class="help-block">
		                    <strong>Max filesize: 10 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
		                </span>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12">
	            		<a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect command-add-inventory-planner-price">Add Package</a>
	            	</div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12">
	            		<div role="tabpanel">
				            <ul class="tab-nav" role="tablist">
				                <li class="active"><a href="#listprint" aria-controls="listprint" role="tab" data-toggle="tab">Print</a></li>
				                <li><a href="#listdigital" aria-controls="listdigital" role="tab" data-toggle="tab">Digital</a></li>
				                <li><a href="#listevent" aria-controls="listevent" role="tab" data-toggle="tab">Event</a></li>
				                <li><a href="#listcreative" aria-controls="listcreative" role="tab" data-toggle="tab">Creative</a></li>
				                <li><a href="#listother" aria-controls="listother" role="tab" data-toggle="tab">Others</a></li>
				            </ul>
				            <div class="tab-content">
				                <div role="tabpanel" class="tab-pane active" id="listprint">
				                   <div class="table-responsive">
				                        <table id="grid-data-listprint" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="print_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="print_advertise_position_name" data-order="asc">Position</th>
				                                    <th data-column-id="print_advertise_size_name" data-order="asc">Size</th>
				                                    <th data-column-id="print_paper_name" data-order="asc">Paper</th>
				                                    <th data-column-id="print_advertise_rate_normal" data-order="asc">Rate</th>
				                                    <th data-column-id="print_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="print_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="print_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="print_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="print_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="print_remarks" data-order="asc">Remarks</th>
				                                    <th data-column-id="print_link" data-formatter="link-rua" data-sortable="false">Action</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listdigital">
				                   <div class="table-responsive">
				                        <table id="grid-data-listdigital" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="digital_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="digital_advertise_position_name" data-order="asc">Position</th>
				                                    <th data-column-id="digital_advertise_size_name" data-order="asc">Size</th>
				                                    <th data-column-id="digital_paper_name" data-order="asc">Paper</th>
				                                    <th data-column-id="digital_advertise_rate_normal" data-order="asc">Rate</th>
				                                    <th data-column-id="digital_startdate" data-order="asc">Start Date</th>
				                                    <th data-column-id="digital_enddate" data-order="asc">End Date</th>
				                                    <th data-column-id="digital_deadline" data-order="asc">Deadline</th>
				                                    <th data-column-id="digital_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="digital_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="digital_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="digital_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="digital_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="digital_remarks" data-order="asc">Remarks</th>
				                                    <th data-column-id="digital_link" data-formatter="link-rua" data-sortable="false">Action</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listevent">
				                   <div class="table-responsive">
				                        <table id="grid-data-listevent" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="event_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="event_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="event_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="event_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="event_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="event_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="event_remarks" data-order="asc">Remarks</th>
				                                    <th data-column-id="event_link" data-formatter="link-rua" data-sortable="false">Action</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listcreative">
				                   <div class="table-responsive">
				                        <table id="grid-data-listcreative" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="creative_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="creative_advertise_position_name" data-order="asc">Position</th>
				                                    <th data-column-id="creative_advertise_size_name" data-order="asc">Size</th>
				                                    <th data-column-id="creative_paper_name" data-order="asc">Paper</th>
				                                    <th data-column-id="creative_advertise_rate_normal" data-order="asc">Rate</th>
				                                    <th data-column-id="creative_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="creative_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="creative_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="creative_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="creative_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="creative_remarks" data-order="asc">Remarks</th>
				                                    <th data-column-id="creative_link" data-formatter="link-rua" data-sortable="false">Action</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                            </tbody>
				                        </table>
				                    </div>                 
				                </div>
				                <div role="tabpanel" class="tab-pane" id="listother">
				                   <div class="table-responsive">
				                        <table id="grid-data-listother" class="table table-hover">
				                            <thead>
				                                <tr>
				                                    <th data-column-id="other_media_name" data-order="asc">Media</th>
				                                    <th data-column-id="other_gross_rate" data-order="asc">Gross Rate</th>
				                                    <th data-column-id="other_surcharge" data-order="asc">Surcharge (%)</th>
				                                    <th data-column-id="other_total_gross_rate" data-order="asc">Total Gross Rate</th>
				                                    <th data-column-id="other_discount" data-order="asc">Discount (%)</th>
				                                    <th data-column-id="other_nett_rate" data-order="asc">Nett Rate</th>
				                                    <th data-column-id="other_remarks" data-order="asc">Remarks</th>
				                                    <th data-column-id="other_link" data-formatter="link-rua" data-sortable="false">Action</th>
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
	            <div class="form-group">
	                <label for="total_value" class="col-sm-2 control-label">Total Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="total_value" id="total_value" placeholder="Total Value" maxlength="20" value="" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="total_nett" class="col-sm-2 control-label">Total Nett</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="total_nett" id="total_nett" placeholder="Total Nett" maxlength="20" value="" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="saving_value" class="col-sm-2 control-label">Saving Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="saving_value" id="saving_value" placeholder="Saving Value" maxlength="20" value="" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('inventory/inventoryplanner') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>

    @include('vendor.material.inventory.inventoryplanner.modal')
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/inventory/inventoryplanner-create.js') }}"></script>
@endsection