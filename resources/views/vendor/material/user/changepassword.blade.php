@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>User Setting<small>Change Password</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('change-password') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="old_password" class="col-sm-2 control-label">Old Password</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="password" class="form-control input-sm" name="old_password" id="old_password" placeholder="Old Password" required="true" maxlength="100" value="">
	                    </div>
	                    @if ($errors->has('old_password'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('old_password') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="new_password" class="col-sm-2 control-label">New Password</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="password" class="form-control input-sm" name="new_password" id="new_password" placeholder="New Password" required="true" maxlength="100" value="">
	                    </div>
	                    @if ($errors->has('new_password'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('new_password') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="confirm_new_password" class="col-sm-2 control-label">Confirm New Password</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="password" class="form-control input-sm" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm New Password" required="true" maxlength="100" value="">
	                    </div>
	                    @if ($errors->has('confirm_new_password'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('confirm_new_password') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('home') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('customjs')
@if(Session::has('errorchangepassword'))
<script type="text/javascript">
$(window).load(function(){
    swal("Failed!", "{{ Session::get('errorchangepassword') }}", "error");
});
</script>
@endif
@endsection