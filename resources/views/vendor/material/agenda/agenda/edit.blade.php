@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Agenda Types Management<small>Edit Agenda Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/agendatype/'.$agendatype->agenda_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="agenda_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="agenda_type_name" id="agenda_type_name" placeholder="Agenda Type Name" required="true" maxlength="100" value="{{ $agendatype->agenda_type_name }}">
	                    </div>
	                    @if ($errors->has('agenda_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('agenda_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="agenda_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="agenda_type_desc" id="agenda_type_desc" class="form-control input-sm" placeholder="Description">{{ $agendatype->agenda_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('agenda_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('agenda_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/agendatype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection