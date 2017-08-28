@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Spot Types Management<small>Edit Color</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/spottype/' . $spottype->spot_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="spot_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="spot_type_name" id="spot_type_name" placeholder="Color Name" required="true" maxlength="100" value="{{ $spottype->spot_type_name }}">
	                    </div>
	                    @if ($errors->has('spot_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('spot_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="spot_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="spot_type_desc" id="spot_type_desc" class="form-control input-sm" placeholder="Description">{{ $spottype->spot_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('spot_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('spot_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/spottype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/spottype-create.js') }}"></script>
@endsection