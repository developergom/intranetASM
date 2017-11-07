@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Agenda Plan<small>Edit Agenda Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('agenda/plan/' . $agenda->agenda_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="agenda_date" class="col-sm-2 control-label">Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="input-group form-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                <div class="dtp-container fg-line">
                                    <input type="text" class="form-control date-picker" name="agenda_date" id="agenda_date" placeholder="AGENDA DATE" required="true" maxlength="10" value="{{ $agenda_date }}" {{ $expired }}>
                                </div>
                            </div>
	                    </div>
	                    @if ($errors->has('agenda_date'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('agenda_date') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
        		<div class="form-group">
        			<label for="agenda_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
        					<select name="agenda_type_id" id="agenda_type_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($agendatypes as $row)
                                	{!! $selected = '' !!}
                                	@if($row->agenda_type_id==$agenda->agenda_type_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->agenda_type_id }}" {{ $selected }}>{{ $row->agenda_type_name }}</option>
								@endforeach
                            </select>
        				</div>
        			</div>
        		</div><!-- 
        		<div class="form-group">
	                <label for="agenda_destination" class="col-sm-2 control-label">Destination</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="agenda_destination" id="agenda_destination" placeholder="Destination" required="true" maxlength="100" value="{{ $agenda->agenda_destination }}">
	                    </div>
	                    @if ($errors->has('agenda_destination'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('agenda_destination') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id[]" id="client_id" class="selectpicker" data-live-search="true">
                            	@foreach ($agenda->clients as $key => $value)
                            		<option value="{{ $value->client_id }}" selected>{{ $value->client_name }}</option>
                            	@endforeach
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="clientcontact" class="col-sm-2 control-label">Contact</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_contact_id[]" id="client_contact_id" class="selectpicker" data-live-search="true" multiple>
                            	@foreach ($agenda->clientcontacts as $key => $value)
                            		<option value="{{ $value->client_contact_id }}" selected>{{ $value->client_contact_name }}</option>
                            	@endforeach
                            </select>
	                    </div>
	                </div>
	            </div><!-- 
	            <div class="form-group">
	                <label for="inventory_planner_id" class="col-sm-2 control-label">Inventory Planner</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="inventory_planner_id[]" id="inventory_planner_id" class="selectpicker" data-live-search="true" multiple>
	                        	@foreach ($agenda->inventories as $key => $value)
                            		<option value="{{ $value->inventory_planner_id }}" selected>{{ $value->inventory_planner_title }}</option>
                            	@endforeach
                            </select>
	                    </div>
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="proposal_id" class="col-sm-2 control-label">Proposal</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="proposal_id[]" id="proposal_id" class="selectpicker" data-live-search="true" multiple>
	                        	@foreach ($agenda->proposals as $key => $value)
                            		<option value="{{ $value->proposal_id }}" selected>{{ $value->proposal_name }}</option>
                            	@endforeach
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="agenda_desc" id="agenda_desc" class="form-control input-sm" placeholder="DESCRIPTION">{{ $agenda->agenda_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('agenda_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('agenda_desc') }}</strong>
			                </span>
			            @endif
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
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/typeahead.bundle.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/agenda/agenda-create.js') }}"></script>
@endsection