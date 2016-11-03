@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>User Management<small>Detail User</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="user_name" class="col-sm-2 control-label">User Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_name" id="user_name" placeholder="User Name" required="true" maxlength="100" value="{{ $user->user_name.' ('.$user->user_status.')' }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_firstname" class="col-sm-2 control-label">First Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_firstname" id="user_firstname" placeholder="First Name" required="true" maxlength="100" value="{{ $user->user_firstname }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_lastname" class="col-sm-2 control-label">Last Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_lastname" id="user_lastname" placeholder="Last Name" maxlength="100" value="{{ $user->user_lastname }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_birthdate" class="col-sm-2 control-label">Birthdate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="user_birthdate" id="user_birthdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $birthdate }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_gender" class="col-sm-2 control-label">Gender</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="user_gender" id="user_gender" placeholder="Gender" maxlength="100" value="{{ ($user->user_gender=='1') ? 'Male' : 'Female' }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="religion_id" class="col-sm-2 control-label">Religion</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="user_religion" id="user_religion" placeholder="Religion" maxlength="100" value="{{ $user->religion->religion_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_email" class="col-sm-2 control-label">Email</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_email" id="user_email" placeholder="Email" required="true" maxlength="100" value="{{ $user->user_email }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_phone" class="col-sm-2 control-label">Phone No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-mask" name="user_phone" id="user_phone" placeholder="Phone No" maxlength="14" value="{{ $user->user_phone }}" autocomplete="off" data-mask="000000000000" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_id" class="col-sm-2 control-label">Role</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($roles as $row)
                            	@foreach ($user->roles as $role)
                            		@if($role->role_id==$row->role_id)
                            			<span class="badge">{{ $row->role_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="group_id" class="col-sm-2 control-label">Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($groups as $row)
                            	@foreach ($user->groups as $group)
                            		@if($group->group_id==$row->group_id)
                            			<span class="badge">{{ $row->group_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Media Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($mediagroups as $row)
                            	@foreach ($user->mediagroups as $mediagroup)
                            		@if($mediagroup->media_group_id==$row->media_group_id)
                            			<span class="badge">{{ $row->media_group_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($medias as $row)
                            	@foreach ($user->medias as $media)
                            		@if($media->media_id==$row->media_id)
                            			<span class="badge">{{ $row->media_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('user') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/app/user-edit.js') }}"></script>
@endsection