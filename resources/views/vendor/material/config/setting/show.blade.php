@extends('vendor.material.layouts.app')Application 

@section('content')
    <div class="card">
        <div class="card-header"><h2>Application Settings Management<small>View Setting</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="setting_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="setting_code" id="setting_code" placeholder="Setting Code" required="true" maxlength="100" value="{{ $setting->setting_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="setting_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="setting_name" id="setting_name" placeholder="Setting Name" required="true" maxlength="100" value="{{ $setting->setting_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="setting_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="setting_desc" id="setting_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $setting->setting_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="setting_value" class="col-sm-2 control-label">Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="setting_value" id="setting_value" class="form-control input-sm" required placeholder="Value" disabled="true">{{ $setting->setting_value }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('config/setting') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection