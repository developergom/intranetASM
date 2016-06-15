@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Sizes Management<small>View Advertise Size</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		<div class="form-group">
	                <label for="advertise_size_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_code" id="advertise_size_code" placeholder="Advertise Size Code" required="true" maxlength="10" value="{{ $advertisesize->advertise_size_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_name" id="advertise_size_name" placeholder="Advertise Size Name" required="true" maxlength="100" value="{{ $advertisesize->advertise_size_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="unit_id" class="col-sm-2 control-label">Unit</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="unit_id" id="unit_id" placeholder="Unit" value="{{ $advertisesize->unit->unit_name . ' (' . $advertisesize->unit->unit_code . ')' }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_width" class="col-sm-2 control-label">Width</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_width" id="advertise_size_width" placeholder="Advertise Size Width" required="true" maxlength="10" value="{{ $advertisesize->advertise_size_width }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_length" class="col-sm-2 control-label">Length</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_size_length" id="advertise_size_length" placeholder="Advertise Size Length" required="true" maxlength="10" value="{{ $advertisesize->advertise_size_length }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_size_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="advertise_size_desc" id="advertise_size_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $advertisesize->advertise_size_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/advertisesize') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection