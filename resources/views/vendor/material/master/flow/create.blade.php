@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/flow-display.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Flows Management<small>Create New Flow</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/flow') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<div class="col-sm-12" id="viz-container">

        			</div>
        		</div>
        		<div class="form-group">
	                <label for="flow_group_id" class="col-sm-2 control-label">Flow Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="flow_group_id" id="flow_group_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($flowgroup as $row)
                                	{!! $selected = '' !!}
                                	@if($row->flow_group_id==old('flow_group_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->flow_group_id }}" {{ $selected }}>{{ $row->flow_group_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('flow_group_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_group_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_name" class="col-sm-2 control-label">Flow Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_name" id="flow_name" placeholder="Flow Name" required="true" maxlength="100" value="{{ old('flow_name') }}">
	                    </div>
	                    @if ($errors->has('flow_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_url" class="col-sm-2 control-label">Flow URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_url" id="flow_url" placeholder="Flow URL" required="true" maxlength="255" value="{{ old('flow_url') }}">
	                    </div>
	                    @if ($errors->has('flow_url'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_url') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_no" class="col-sm-2 control-label">Flow No</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="select">
		                        <select name="flow_no" id="flow_no" class="selectpicker" data-live-search="true" required="true">
		                        	<option value=""></option>
		                        </select>
	                        </div>
	                    </div>
	                    @if ($errors->has('flow_no'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_no') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <!-- <div class="form-group">
	                <label for="flow_next" class="col-sm-2 control-label">Next Flow</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="select">
		                        <select name="flow_next" id="flow_next" class="form-control" required="true">
		                        	<option value="">SELECT AN OPTION</option>
		                        </select>
	                        </div>
	                    </div>
	                    @if ($errors->has('flow_next'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_next') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="flow_prev" class="col-sm-2 control-label">Previous Flow</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="select">
		                        <select name="flow_prev" id="flow_prev" class="selectpicker" data-live-search="true" required="true">
		                        	<option value=""></option>
		                        </select>
	                        </div>
	                    </div>
	                    @if ($errors->has('flow_prev'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_prev') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_by" class="col-sm-2 control-label">Flow By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="flow_by" id="flow_by" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($flowbyitems as $key => $value)
                                	{!! $selected = '' !!}
                                	@if($key == old('flow_by'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $key }}" {{ $selected }}>{{ $value }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('flow_by'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_by') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_id" class="col-sm-2 control-label">Role</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="role_id" id="role_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($role as $row)
                                	{!! $selected = '' !!}
                                	@if($row->role_id==old('role_id'))
                                		{!! $selected = 'selected' !!}
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
	            	<label for="flow_using_optional" class="col-sm-2 control-label">Using Optional Flow?</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<select name="flow_using_optional" id="flow_using_optional" class="selectpicker" required="true">
	            				<option value="0">No</option>
	            				<option value="1">Yes</option>
	            			</select>
	            		</div>
	            		@if ($errors->has('flow_using_optional'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_using_optional') }}</strong>
			                </span>
			            @endif
	            	</div>
	            </div>
	            <div class="form-group next-optional-container">
	            	<label for="flow_next_optional" class="col-sm-2 control-label">Flow Next Optional</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_next_optional" id="flow_next_optional" placeholder="Flow Next Optional" maxlength="3" value="{{ old('flow_next_optional') }}">
	                    </div>
	                    @if ($errors->has('flow_next_optional'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_next_optional') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group next-optional-container">
	            	<label for="flow_condition" class="col-sm-2 control-label">Flow Next Condition</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<select name="flow_condition" id="flow_condition" class="selectpicker">
	            				<option value="">CHOOSE ONE</option>
	            				<option value="EQUAL">=</option>
	            				<option value="NOT_EQUAL"><></option>
	            				<option value="GREATER">></option>
	            				<option value="GREATER_EQUAL">>=</option>
	            				<option value="LESS"><</option>
	            				<option value="LESS_EQUAL"><=</option>
	            			</select>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group next-optional-container">
	            	<label for="flow_condition_value" class="col-sm-2 control-label">Flow Next Condition Value</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_condition_value" id="flow_condition_value" placeholder="Flow Next Condition Value (input only number)" maxlength="10" value="{{ old('flow_condition_value') }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/flow') }}" class="btn btn-danger btn-sm">Back</a>
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
<script src="{{ url('js/master/flow-create.js') }}"></script>
<script src="{{ url('js/master/flow-display.js') }}"></script>
@endsection