@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Holidays Management<small>Edit Holiday</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/holiday/' . $holiday->holiday_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="holiday_name" class="col-sm-2 control-label">Holiday Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="holiday_name" id="holiday_name" placeholder="Holiday Name" required="true" maxlength="100" value="{{ $holiday->holiday_name }}">
	                    </div>
	                    @if ($errors->has('holiday_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('holiday_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="holiday_date" class="col-sm-2 control-label">Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="holiday_date" id="holiday_date" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $holiday->holiday_date->format('d/m/Y') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('holiday_date'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('holiday_date') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/holiday') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection