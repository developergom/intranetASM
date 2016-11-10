@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Planner<small>Create New Inventory Planner</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('inventory/inventoryplanner') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="inventory_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="inventory_type_id" id="inventory_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($inventory_types as $row)
	        						{!! $selected = '' !!}
                                	@if(old('inventory_type_id'))
	                                	@foreach (old('inventory_type_id') as $key => $value)
	                                		@if($value==$row->inventory_type_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
	        						<option value="{{ $row->inventory_type_id }}" {{ $selected }}>{{ $row->inventory_type_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('inventory_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('inventory_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="inventory_planner_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_title" id="inventory_planner_title" placeholder="Inventory Planner Title" required="true" maxlength="255" value="{{ old('inventory_planner_title') }}">
	                    </div>
	                    @if ($errors->has('inventory_planner_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="inventory_planner_desc" id="inventory_planner_desc" class="form-control input-sm" placeholder="Description">{{ old('inventory_planner_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('inventory_planner_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="implementation_id" class="col-sm-2 control-label">Implementation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="implementation_id[]" id="implementation_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($implementations as $row)
                                	{!! $selected = '' !!}
                                	@if(old('implementation_id'))
	                                	@foreach (old('implementation_id') as $key => $value)
	                                		@if($value==$row->implementation_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->implementation_id }}" {{ $selected }}>{{ $row->implementation_month_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('implementation_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('implementation_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="inventory_planner_year" id="inventory_planner_year" placeholder="e.g 1945" required="true" maxlength="4" value="{{ old('inventory_planner_year') }}" autocomplete="off" data-mask="0000">
	                    </div>
	                    @if ($errors->has('inventory_planner_year'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_year') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="inventory_planner_deadline" id="inventory_planner_deadline" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('inventory_planner_deadline') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('inventory_planner_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@if(old('media_id'))
	                                	@foreach (old('media_id') as $key => $value)
	                                		@if($value==$row->media_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
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
	                <label for="action_plan_id" class="col-sm-2 control-label">Action Plan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="action_plan_id[]" id="action_plan_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($action_plans as $row)
                                	{!! $selected = '' !!}
                                	@if(old('action_plan_id'))
	                                	@foreach (old('action_plan_id') as $key => $value)
	                                		@if($value==$row->action_plan_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->action_plan_id }}" {{ $selected }}>{{ $row->action_plan_title }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('action_plan_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_id" class="col-sm-2 control-label">Event Plan</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="event_plan_id[]" id="event_plan_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($event_plans as $row)
                                	{!! $selected = '' !!}
                                	@if(old('event_plan_id'))
	                                	@foreach (old('event_plan_id') as $key => $value)
	                                		@if($value==$row->event_plan_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->event_plan_id }}" {{ $selected }}>{{ $row->event_plan_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('event_plan_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="dropzone" id="uploadFileArea">
	                        	
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect command-add-inventory-planner-price">Add Edition</a>
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('inventory/inventoryplanner') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>

    @include('vendor.material.inventory.inventoryplanner.modal')
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/inventory/inventoryplanner-create.js') }}"></script>
@endsection