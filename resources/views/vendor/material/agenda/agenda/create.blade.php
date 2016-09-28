@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Agenda Plan<small>Create New Agenda Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('agenda/plan') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
	                <label for="agenda_date" class="col-sm-2 control-label">Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="input-group form-group">
                                <span class="input-group-addon"><i class="zmdi zmdi-calendar"></i></span>
                                <div class="dtp-container fg-line">
                                    <input type="text" class="form-control date-picker" name="agenda_date" id="agenda_date" placeholder="Agenda Date" required="true" maxlength="10" value="{{ old('agenda_date') }}">
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
                                	@if($row->agenda_type_id==old('agenda_type_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->agenda_type_id }}" {{ $selected }}>{{ $row->agenda_type_name }}</option>
								@endforeach
                            </select>
        				</div>
        			</div>
        		</div>
        		<div class="form-group">
	                <label for="agenda_destination" class="col-sm-2 control-label">Destination</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="agenda_destination" id="agenda_destination" placeholder="Destination" required="true" maxlength="100" value="{{ old('agenda_destination') }}">
	                    </div>
	                    @if ($errors->has('agenda_destination'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('agenda_destination') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client" id="client" placeholder="Client" maxlength="100" autocomplete="off">
	                    </div>
	                    <div id="list-client-id">
						</div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="clientcontact" class="col-sm-2 control-label">Contact</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="clientcontact" id="clientcontact" placeholder="Contact" maxlength="100" autocomplete="off">
	                    </div>
	                    <div id="list-clientcontact-id">
						</div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="agenda_desc" id="agenda_desc" class="form-control input-sm" placeholder="Description">{{ old('agenda_desc') }}</textarea>
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
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/typeahead.bundle.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/agenda/agenda-create.js') }}"></script>
@endsection