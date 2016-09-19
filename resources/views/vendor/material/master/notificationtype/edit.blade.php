@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Notification Types Management<small>Create New Notification Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/notificationtype/'.$notificationtype->notification_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="notification_type_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="notification_type_code" id="notification_type_code" placeholder="Notification Type Code" required="true" maxlength="50" value="{{ $notificationtype->notification_type_code }}">
	                    </div>
	                    @if ($errors->has('notification_type_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('notification_type_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="notification_type_name" id="notification_type_name" placeholder="Notification Type Name" required="true" maxlength="255" value="{{ $notificationtype->notification_type_name }}">
	                    </div>
	                    @if ($errors->has('notification_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('notification_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_url" class="col-sm-2 control-label">URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="notification_type_url" id="notification_type_url" placeholder="Notification Type URL" required="true" maxlength="255" value="{{ $notificationtype->notification_type_url }}">
	                    </div>
	                    @if ($errors->has('notification_type_url'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('notification_type_url') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="notification_type_desc" id="notification_type_desc" class="form-control input-sm" placeholder="Description">{{ $notificationtype->notification_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('notification_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('notification_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="notification_type_need_confirmation" class="col-sm-2 control-label">Need Confirmation?</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<div class="radio m-b-15">
	                    		<label>
		                        	<input type="radio" name="notification_type_need_confirmation" value="1" {{ ($notificationtype->notification_type_need_confirmation=='1') ? 'checked' : '' }}>
		                        	<i class="input-helper"></i>
		                        	Yes
		                        </label>
	                    	</div>
	                    	<div class="radio m-b-15">
	                    		<label>
		                        	<input type="radio" name="notification_type_need_confirmation" value="0" {{ ($notificationtype->notification_type_need_confirmation=='0') ? 'checked' : '' }}>
		                        	<i class="input-helper"></i>
		                        	No
		                        </label>
	                    	</div>
	                    </div>
	                    @if ($errors->has('notification_type_need_confirmation'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('notification_type_need_confirmation') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/notificationtype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection