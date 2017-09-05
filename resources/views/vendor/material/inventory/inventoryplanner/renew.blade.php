@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Planner<small>Edit Inventory Planner</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('inventory/inventoryplanner/renew/' . $inventory->inventory_planner_id) }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="proposal_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="proposal_type_id" id="proposal_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($proposal_types as $row)
	        						{!! $selected = '' !!}
                                	@if($inventory->proposal_type_id==$row->proposal_type_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_desc}}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('proposal_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('proposal_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
        		<div class="form-group">
        			<label for="inventory_category_id" class="col-sm-2 control-label">Category</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="inventory_category_id[]" id="inventory_category_id" class="selectpicker" multiple data-live-search="true" required="true">
	        					<!-- <option value=""></option> -->
	        					@foreach ($inventory_categories as $row)
                                	{!! $selected = '' !!}
                                	@if($inventory->inventorycategories)
	                                	@foreach ($inventory->inventorycategories as $key => $value)
	                                		@if($value->inventory_category_id==$row->inventory_category_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->inventory_category_id }}" {{ $selected }}>{{ $row->inventory_category_name }}</option>
								@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('inventory_category_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('inventory_category_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="inventory_planner_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_title" id="inventory_planner_title" placeholder="Inventory Planner Title" required="true" maxlength="100" value="{{ $inventory->inventory_planner_title }}">
	                    </div>
	                    @if ($errors->has('inventory_planner_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="implementation_id" class="col-sm-2 control-label">Implementation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="implementation_id[]" id="implementation_id" class="selectpicker" data-live-search="true" multiple required="true" title="filled with month(s) of the inventory’s implementation">
                                @foreach ($implementations as $row)
                                	{!! $selected = '' !!}
                                	@if($inventory->implementations)
	                                	@foreach ($inventory->implementations as $key => $value)
	                                		@if($value->implementation_id==$row->implementation_id)
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
	                        <input type="text" class="form-control input-sm input-mask" name="inventory_planner_year" id="inventory_planner_year" placeholder="e.g 1945" required="true" maxlength="4" value="{{ $inventory->inventory_planner_year }}" autocomplete="off" data-mask="0000">
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
	                        <input type="text" class="form-control input-sm input-mask" name="inventory_planner_deadline" id="inventory_planner_deadline" placeholder="e.g 17/08/1945 (filled with the deadline which the inventory can be sold)" required="true" maxlength="10" value="{{ $inventory_deadline }}" autocomplete="off" data-mask="00/00/0000" data-toggle="tooltip" data-placement="bottom" title="filled with the deadline which the inventory can be sold">
	                    </div>
	                    @if ($errors->has('inventory_planner_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div><!-- 
	            <div class="form-group">
	                <label for="inventory_planner_participants" class="col-sm-2 control-label">Participants</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_participants" id="inventory_planner_participants" placeholder="Please input only numeric character" required="true" maxlength="12" value="{{ $inventory->inventory_planner_participants }}">
	                    </div>
	                    @if ($errors->has('inventory_planner_participants'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_participants') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@if($inventory->medias)
	                                	@foreach ($inventory->medias as $key => $value)
	                                		@if($value->media_id==$row->media_id)
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
	                <label for="inventory_planner_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="inventory_planner_desc" id="inventory_planner_desc" class="form-control input-sm" placeholder="Description">{{ $inventory->inventory_planner_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('inventory_planner_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_desc') }}</strong>
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
	                    <span class="help-block">
		                    <strong>Max filesize: 10 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
		                </span>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('inventory/inventoryplanner') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
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