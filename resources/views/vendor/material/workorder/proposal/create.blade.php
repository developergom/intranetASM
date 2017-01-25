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
        <div class="card-header"><h2>Proposal<small>Create New Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('workorder/proposal') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="proposal_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="proposal_type_id" id="proposal_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($proposal_types as $row)
	        						{!! $selected = '' !!}
                                	@if(old('proposal_type_id')==$row->proposal_type_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('proposal_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('proposal_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="proposal_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_name" id="proposal_name" placeholder="Proposal Name" required="true" maxlength="100" value="{{ old('proposal_name') }}">
	                    </div>
	                    @if ($errors->has('proposal_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="industry_id[]" id="industry_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($industries as $row)
                                	{!! $selected = '' !!}
                                	@if(old('industry_id'))
	                                	@foreach (old('industry_id') as $key => $value)
	                                		@if($value==$row->industry_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
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
	                <label for="proposal_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_deadline" id="proposal_deadline" placeholder="Deadline" required="true" maxlength="100" value="{{ old('proposal_deadline') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('proposal_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="proposal_desc" id="proposal_desc" class="form-control input-sm" placeholder="Description">{{ old('proposal_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('proposal_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_id" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id" id="client_id" class="selectpicker with-ajax" data-live-search="true" required="true">
                                
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
	                <label for="client_contact_id" class="col-sm-2 control-label">Contact</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_contact_id[]" id="client_contact_id" class="selectpicker" data-live-search="true" multiple required="true">
                            </select>
	                    </div>
	                    @if ($errors->has('client_contact_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_contact_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="brand_id" class="col-sm-2 control-label">Brand</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="brand_id" id="brand_id" class="selectpicker" data-live-search="true" required="true">
                            </select>
	                    </div>
	                    @if ($errors->has('brand_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('brand_id') }}</strong>
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
	                <label for="inventory_planner_id" class="col-sm-2 control-label">Inventory Planner</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="inventory_planner_id[]" id="inventory_planner_id" class="selectpicker with-ajax" data-live-search="true" multiple>
                                
                            </select>
	                    </div>
	                    @if ($errors->has('inventory_planner_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_id') }}</strong>
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
	            		<a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect command-add-proposal-price">Add Package</a>
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
	                    <a href="{{ url('workorder/proposal') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>

    @include('vendor.material.workorder.proposal.modal')
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/workorder/proposal-create.js') }}"></script>
@endsection