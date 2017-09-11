@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Agenda Plan<small>Do Report Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('agenda/plan/do_report/' . $agenda->agenda_id) }}">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="agenda_date" class="col-sm-2 control-label">Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control date-picker" name="agenda_date" id="agenda_date" placeholder="Agenda Date" required="true" maxlength="10" value="{{ $agenda_date }}" readonly="true">
	                    </div>
	                </div>
	            </div>
        		<div class="form-group">
        			<label for="agenda_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
        					<input type="text" name="agenda_type_id" class="form-control" placeholder="Agenda Type" value="{{ $agenda->agendatype->agenda_type_name }}" readonly="true">
        				</div>
        			</div>
        		</div><!-- 
        		<div class="form-group">
	                <label for="agenda_destination" class="col-sm-2 control-label">Destination</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="agenda_destination" id="agenda_destination" placeholder="Destination" required="true" maxlength="100" value="{{ $agenda->agenda_destination }}" readonly="true">
	                    </div>
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($agenda->clients as $client)
								<a href="{{ url('/master/client/' . $client->client_id) }}" target="_blank"><span id="span-client-id-{{ $client->client_id }}" class="badge">{{ $client->client_name }}&nbsp;</span></a>&nbsp;
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="clientcontact" class="col-sm-2 control-label">Contact</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($agenda->clientcontacts as $clientcontact)
								<a href="{{ url('/master/client/' . $clientcontact->client_id) }}" target="_blank"><span id="span-clientcontact-id-{{ $clientcontact->client_contact_id }}" class="badge">{{ $clientcontact->client_contact_name . ' - ' . $clientcontact->client->client_name }}&nbsp;</span></a>&nbsp;
							@endforeach
	                    </div>
	                </div>
	            </div><!-- 
	            <div class="form-group">
	                <label for="inventory_planner_id" class="col-sm-2 control-label">Inventory Planner</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                        	@foreach ($agenda->inventories as $key => $value)
                        		<span id="span-inventory-id-{{ $value->inventory_planner_id }}" class="badge">{{ $value->inventory_planner_title }}&nbsp;</span>&nbsp;
                        	@endforeach
	                    </div>
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="proposal_id" class="col-sm-2 control-label">Proposal</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                        	@foreach ($agenda->proposals as $key => $value)
                        		<a href="{{ url('/workorder/proposal/' . $value->proposal_id) }}" target="_blank"><span id="span-proposal-id-{{ $value->proposal_id }}"class="badge">{{ $value->proposal_name . ' - ' . $value->proposal_no }}&nbsp;</span></a>&nbsp;
                        	@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="agenda_desc" id="agenda_desc" class="form-control input-sm" placeholder="Description" readonly="true">{{ $agenda->agenda_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_is_report" class="col-sm-2 control-label">Status</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <span class="badge">{{ ($agenda->agenda_is_report=='1') ? 'REPORTED' : 'UNREPORTED' }}</span>
	                    </div>
	                </div>
	            </div>
	            <hr/>
	            <div class="form-group">
	                <label for="created_at" class="col-sm-2 control-label">Created At</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control" name="created_at" id="created_at" placeholder="Created At" required="true" value="{{ $created_at }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="created_by" class="col-sm-2 control-label">Created By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control" name="created_by" id="created_by" placeholder="Created By" required="true" value="{{ $agenda->created_by->user_firstname . ' ' . $agenda->created_by->user_lastname }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <hr/>
	            <div class="form-group">
	                <label for="agenda_meeting_time" class="col-sm-2 control-label">Meeting Time</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control date-picker" name="agenda_meeting_time" id="agenda_meeting_time" placeholder="Meeting Time" required="true" value="">
	                    </div>
	                </div>
	            </div><!-- 
	            <div class="form-group">
	                <label for="agenda_report_time" class="col-sm-2 control-label">Report Time</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control date-picker" name="agenda_report_time" id="agenda_report_time" placeholder="Report Time" required="true" value="">
	                    </div>
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="agenda_report_desc" class="col-sm-2 control-label">Report Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="agenda_report_desc" id="agenda_report_desc" class="form-control input-sm" placeholder="Report Description"></textarea>
	                    </div>
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
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('agenda/plan') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/typeahead.bundle.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/agenda/agenda-doreport.js') }}"></script>
@endsection