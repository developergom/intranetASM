@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Notification Types Management<small>View Notification Type Detail</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="notification_type_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="notification_type_code" id="notification_type_code" placeholder="Notification Type Code" required="true" maxlength="50" value="{{ $notificationtype->notification_type_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="notification_type_name" id="notification_type_name" placeholder="Notification Type Name" required="true" maxlength="255" value="{{ $notificationtype->notification_type_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_url" class="col-sm-2 control-label">URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="notification_type_url" id="notification_type_url" placeholder="Notification Type URL" required="true" maxlength="255" value="{{ $notificationtype->notification_type_url }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="notification_type_desc" id="notification_type_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $notificationtype->notification_type_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_need_confirmation" class="col-sm-2 control-label">Need Confirmation?</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="notification_type_need_confirmation" id="notification_type_need_confirmation" placeholder="Gender" maxlength="100" value="{{ ($notificationtype->notification_type_need_confirmation=='1') ? 'Yes' : 'No' }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/notificationtype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection