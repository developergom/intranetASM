@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Agenda Plan<small>View Agenda Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="agenda_date" class="col-sm-2 control-label">Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control date-picker" name="agenda_date" id="agenda_date" placeholder="Agenda Date" required="true" maxlength="10" value="{{ $agenda_date }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_report_expired_date" class="col-sm-2 control-label">Report Expired Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control date-picker" name="agenda_report_expired_date" id="agenda_report_expired_date" placeholder="Agenda Report Expired Date" required="true" maxlength="10" value="{{ $agenda_report_expired_date }}" readonly="true">
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
	                    {!! $agenda->agenda_desc !!}
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
	            @if($agenda->agenda_is_report=='1')
	            <div class="form-group">
	                <label for="agenda_meeting_time" class="col-sm-2 control-label">Meeting Time</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control" name="agenda_meeting_time" id="agenda_meeting_time" placeholder="Meeting Time" required="true" value="{{ $agenda_meeting_time }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_report_time" class="col-sm-2 control-label">Report Time</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            <input type="text" class="form-control" name="agenda_report_time" id="agenda_report_time" placeholder="Report Time" required="true" value="{{ $agenda_report_time }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_report_desc" class="col-sm-2 control-label">Report Description</label>
	                <div class="col-sm-10">
	                    {!! $agenda->agenda_report_desc !!}
	                </div>
	            </div>
	            <div class="form-group">
				    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($agenda->uploadfiles as $uploadedfile)
				        	<div class="col-sm-6 col-md-3">
				        		<div class="thumbnail">
				        			@if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
				        			<img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
				        			@else
				        			<img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
				        			@endif
				        			<div class="caption">
				        				<h6>{{ $uploadedfile->upload_file_name }}</h6>
				        				<p>{{ $uploadedfile->upload_file_desc }}</p>
				        				<div class="m-b-5">
				        					<a class="btn btn-sm btn-primary waves-effect" href="{{ url('download/file/' . $uploadedfile->upload_file_id) }}" role="button">Download File</a>
				        				</div>
				        			</div>
				        		</div>
				        	</div>
				        	@endforeach
				        </div>
				    </div>
				</div>
	            @endif
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
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
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
@endsection