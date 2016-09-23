@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Sizes Management<small>Create New Advertise Size</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/advertisesize') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="advertise_size_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_code" id="advertise_size_code" placeholder="Advertise Size Code" required="true" maxlength="10" value="{{ old('advertise_size_code') }}">
	                    </div>
	                    @if ($errors->has('advertise_size_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_size_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_name" id="advertise_size_name" placeholder="Advertise Size Name" required="true" maxlength="100" value="{{ old('advertise_size_name') }}">
	                    </div>
	                    @if ($errors->has('advertise_size_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_size_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="unit_id" class="col-sm-2 control-label">Unit</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="unit_id" id="unit_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($unit as $row)
                                	{!! $selected = '' !!}
                                	@if($row->unit_id==old('unit_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->unit_id }}" {{ $selected }}>{{ $row->unit_name . ' (' . $row->unit_code . ')' }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('unit_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('unit_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_width" class="col-sm-2 control-label">Width</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_width" id="advertise_size_width" placeholder="Advertise Size Width" required="true" maxlength="10" value="{{ old('advertise_size_width') }}">
	                    </div>
	                    @if ($errors->has('advertise_size_width'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_size_width') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_length" class="col-sm-2 control-label">Length</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_length" id="advertise_size_length" placeholder="Advertise Size Length" required="true" maxlength="10" value="{{ old('advertise_size_length') }}">
	                    </div>
	                    @if ($errors->has('advertise_size_length'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_size_length') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="advertise_size_desc" id="advertise_size_desc" class="form-control input-sm" placeholder="Description">{{ old('advertise_size_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('advertise_size_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_size_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/advertisesize') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection