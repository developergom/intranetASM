@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>User Management<small>Edit User</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('user/'.$user->user_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="user_name" class="col-sm-2 control-label">User Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_name" id="user_name" placeholder="User Name" required="true" maxlength="100" value="{{ $user->user_name }}">
	                    </div>
	                    @if ($errors->has('user_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_firstname" class="col-sm-2 control-label">First Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_firstname" id="user_firstname" placeholder="First Name" required="true" maxlength="100" value="{{ $user->user_firstname }}">
	                    </div>
	                    @if ($errors->has('user_firstname'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_firstname') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_lastname" class="col-sm-2 control-label">Last Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_lastname" id="user_lastname" placeholder="Last Name" maxlength="100" value="{{ $user->user_lastname }}">
	                    </div>
	                    @if ($errors->has('user_lastname'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_lastname') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_birthdate" class="col-sm-2 control-label">Birthdate</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="user_birthdate" id="user_birthdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $birthdate }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('user_birthdate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_birthdate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_gender" class="col-sm-2 control-label">Gender</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<div class="radio m-b-15">
	                    		<label>
		                        	<input type="radio" name="user_gender" value="1" {{ ($user->user_gender=='1') ? 'checked' : '' }}>
		                        	<i class="input-helper"></i>
		                        	Male
		                        </label>
	                    	</div>
	                    	<div class="radio m-b-15">
	                    		<label>
		                        	<input type="radio" name="user_gender" value="2" {{ ($user->user_gender=='2') ? 'checked' : '' }}>
		                        	<i class="input-helper"></i>
		                        	Female
		                        </label>
	                    	</div>
	                    </div>
	                    @if ($errors->has('user_gender'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_gender') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="religion_id" class="col-sm-2 control-label">Religion</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="religion_id" id="religion_id" class="selectpicker" data-live-search="true" required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($religion as $row)
                                	{!! $selected = '' !!}
                                	@if($row->religion_id==$user->religion_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->religion_id }}" {{ $selected }}>{{ $row->religion_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('religion_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('religion_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_email" class="col-sm-2 control-label">Email</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_email" id="user_email" placeholder="Email" required="true" maxlength="100" value="{{ $user->user_email }}">
	                    </div>
	                    @if ($errors->has('user_email'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_email') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="user_phone" class="col-sm-2 control-label">Phone No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-mask" name="user_phone" id="user_phone" placeholder="Phone No" maxlength="14" value="{{ $user->user_phone }}" autocomplete="off" data-mask="000000000000">
	                    </div>
	                    @if ($errors->has('user_phone'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('user_phone') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_id" class="col-sm-2 control-label">Role</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="role_id[]" id="role_id" class="selectpicker" data-live-search="true" multiple required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($roles as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($user->roles as $role)
                                		@if($role->role_id==$row->role_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option value="{{ $row->role_id }}" {{ $selected }}>{{ $row->role_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('role_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('role_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="group_id" class="col-sm-2 control-label">Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="group_id[]" id="group_id" class="selectpicker" data-live-search="true" multiple required="true">
	                        	<!-- <option value=""></option> -->
                                @foreach ($groups as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($user->groups as $group)
                                		@if($group->group_id==$row->group_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option value="{{ $row->group_id }}" {{ $selected }}>{{ $row->group_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('group_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('group_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Media Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_group_id[]" id="media_group_id" class="selectpicker" data-live-search="true" multiple>
	                        	<!-- <option value=""></option> -->
                                @foreach ($mediagroups as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($user->mediagroups as $mediagroup)
                                		@if($mediagroup->media_group_id==$row->media_group_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option value="{{ $row->media_group_id }}" {{ $selected }}>{{ $row->media_group_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_group_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_group_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="selectpicker" data-live-search="true" multiple>
	                        	<!-- <option value=""></option> -->
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($user->medias as $media)
                                		@if($media->media_id==$row->media_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="reset_password" class="col-sm-2 control-label"></label>
	                <div class="col-sm-10">
	                	<div class="checkbox m-b-15">
	                		<label>
	                            <input value="yes" type="checkbox" name="reset_password">
	                            <i class="input-helper"></i>
	                            Please check if you want to reset the password
	                        </label>
	                	</div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
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