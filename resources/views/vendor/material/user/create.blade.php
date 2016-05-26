@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>User Management<small>Create New User</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('user') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="user_name" class="col-sm-2 control-label">User Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="user_name" id="user_name" placeholder="User Name" required="true" maxlength="100" value="{{ old('user_name') }}">
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
	                        <input type="text" class="form-control input-sm" name="user_firstname" id="user_firstname" placeholder="First Name" required="true" maxlength="100" value="{{ old('user_firstname') }}">
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
	                        <input type="text" class="form-control input-sm" name="user_lastname" id="user_lastname" placeholder="Last Name" maxlength="100" value="{{ old('user_lastname') }}">
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
	                        <input type="text" class="form-control input-sm input-mask" name="user_birthdate" id="user_birthdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('user_birthdate') }}" autocomplete="off" data-mask="00/00/0000">
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
		                        	<input type="radio" name="user_gender" value="1" {{ (old('user_gender')=='1') ? 'checked' : '' }}>
		                        	<i class="input-helper"></i>
		                        	Male
		                        </label>
	                    	</div>
	                    	<div class="radio m-b-15">
	                    		<label>
		                        	<input type="radio" name="user_gender" value="2" {{ (old('user_gender')=='2') ? 'checked' : '' }}>
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
	                        <select name="religion_id" id="religion_id" class="chosen" required="true">
	                        	<option value=""></option>
                                @foreach ($religion as $row)
                                	{!! $selected = '' !!}
                                	@if($row->religion_id==old('religion_id'))
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
	                        <input type="text" class="form-control input-sm" name="user_email" id="user_email" placeholder="Email" required="true" maxlength="100" value="{{ old('user_email') }}">
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
	                        <input type="text" class="form-control input-mask" name="user_phone" id="user_phone" placeholder="Phone No" maxlength="14" value="{{ old('user_phone') }}" autocomplete="off" data-mask="000000000000">
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
	                        <select name="role_id[]" id="role_id" class="chosen" multiple required="true">
	                        	<option value=""></option>
                                @foreach ($roles as $row)
                                	{!! $selected = '' !!}
                                	@if(old('role_id'))
	                                	@foreach (old('role_id') as $key => $value)
	                                		@if($value==$row->role_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
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
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/app/user-create.js') }}"></script>
@endsection