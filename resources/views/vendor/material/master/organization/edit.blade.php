@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Organization Management<small>Edit Organization</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/organization/' . $organization->organization_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="organization_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_name" id="organization_name" placeholder="Organization Name" required="true" maxlength="100" value="{{ $organization->organization_name }}" >
	                    </div>
	                    @if ($errors->has('organization_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('organization_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_account_name" class="col-sm-2 control-label">Account Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_account_name" id="organization_account_name" placeholder="Account Name" maxlength="100" value="{{ $organization->organization_account_name }}">
	                    </div>
	                    @if ($errors->has('organization_account_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('organization_account_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_account_no" class="col-sm-2 control-label">Account No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_account_no" id="organization_account_no" placeholder="Account No" maxlength="100" value="{{ $organization->organization_account_no }}">
	                    </div>
	                    @if ($errors->has('organization_account_no'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('organization_account_no') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_term_of_payment" class="col-sm-2 control-label">Term of Payment (day)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="organization_term_of_payment" id="organization_term_of_payment" placeholder="Term of Payment (day)" maxlength="100" value="{{ $organization->organization_term_of_payment }}">
	                    </div>
	                    @if ($errors->has('organization_term_of_payment'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('organization_term_of_payment') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="organization_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="fg-line">
	                        <textarea name="organization_desc" id="organization_desc" class="form-control input-sm" placeholder="Description">{{ $organization->organization_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('organization_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('organization_desc') }}</strong>
			                </span>
			            @endif
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/organization') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection