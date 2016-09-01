@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Action Plans<small>Create New Action Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('plan/actionplan') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="action_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="action_type_id" id="action_type_id" class="chosen" required="true">
	        					<option value=""></option>
	        					@foreach($actiontypes as $row)
	        						<option value="{{ $row->action_type_id }}">{{ $row->action_type_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('action_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('action_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="action_plan_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_plan_title" id="action_plan_title" placeholder="Action Plan Title" required="true" maxlength="100" value="{{ old('action_plan_title') }}">
	                    </div>
	                    @if ($errors->has('action_plan_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="action_plan_desc" id="action_plan_desc" class="form-control input-sm" placeholder="Description">{{ old('action_plan_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('action_plan_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('plan/actionplan') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
@endsection