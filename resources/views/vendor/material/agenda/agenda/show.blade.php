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
                            <input type="text" class="form-control date-picker" name="agenda_date" id="agenda_date" placeholder="Agenda Date" required="true" maxlength="10" value="{{ $agenda_date }}" disabled="true">
	                    </div>
	                </div>
	            </div>
        		<div class="form-group">
        			<label for="agenda_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
        					<input type="text" name="agenda_type_id" class="form-control" placeholder="Agenda Type" value="{{ $agenda->agendatype->agenda_type_name }}" disabled="true">
        				</div>
        			</div>
        		</div>
        		<div class="form-group">
	                <label for="agenda_destination" class="col-sm-2 control-label">Destination</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="agenda_destination" id="agenda_destination" placeholder="Destination" required="true" maxlength="100" value="{{ $agenda->agenda_destination }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($agenda->clients as $client)
								<span id="span-client-id-{{ $client->client_id }}" class="badge">{{ $client->client_name }}&nbsp;</span>&nbsp;
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="clientcontact" class="col-sm-2 control-label">Contact</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        @foreach($agenda->clientcontacts as $clientcontact)
								<span id="span-clientcontact-id-{{ $clientcontact->client_contact_id }}" class="badge">{{ $clientcontact->client_contact_name . ' - ' . $clientcontact->client->client_name }}&nbsp;</span>&nbsp;
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="agenda_desc" id="agenda_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $agenda->agenda_desc }}</textarea>
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