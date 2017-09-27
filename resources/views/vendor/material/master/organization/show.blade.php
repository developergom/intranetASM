@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Organization Management<small>View Organization</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="organization_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_name" id="organization_name" placeholder="Organization Name" required="true" maxlength="100" value="{{ $organization->organization_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_account_name" class="col-sm-2 control-label">Account Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_account_name" id="organization_account_name" placeholder="Account Name" required="true" maxlength="100" value="{{ $organization->organization_account_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_account_no" class="col-sm-2 control-label">Account No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_account_no" id="organization_account_no" placeholder="Account No" required="true" maxlength="100" value="{{ $organization->organization_account_no }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_term_of_payment" class="col-sm-2 control-label">Term of Payment (day)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_term_of_payment" id="organization_term_of_payment" placeholder="Term of Payment (day)" required="true" maxlength="100" value="{{ $organization->organization_term_of_payment }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        {!! $organization->organization_desc !!}
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="medias" class="col-sm-2 control-label">Media(s)</label>
	            	<div class="col-sm-10">
	            		@foreach($organization->medias as $media)
	            			<a href="{{ url('/master/media/' . $media->media_id) }}" target="_blank"><span class="badge">{{ $media->media_name }}</span></a><br/>
	            		@endforeach
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/organization') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection