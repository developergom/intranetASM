@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
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
	        						<option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name }} - {!! $row->proposal_type_desc !!}</option>
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
        			<label for="inventory_source_id" class="col-sm-2 control-label">Source</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="inventory_source_id" id="inventory_source_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($inventory_sources as $row)
	        						{!! $selected = '' !!}
                                	@if($inventory->inventory_source_id==$row->inventory_source_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->inventory_source_id }}" {{ $selected }}>{{ $row->inventory_source_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('inventory_source_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('inventory_source_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="inventory_planner_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_title" id="inventory_planner_title" placeholder="INVENTORY PLANNER TITLE" required="true" maxlength="100" value="{{ $inventory->inventory_planner_title }}">
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
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <select name="implementation_id" id="implementation_id" class="selectpicker" data-live-search="true" title="filled with month(s) of the inventory’s implementation">
                                @foreach ($implementations as $row)
                                	{!! $selected = '' !!}
								    <option value="{{ $row->implementation_id }}" {{ $selected }}>{{ $row->implementation_month_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                </div>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="implementation_year" id="implementation_year" placeholder="e.g 1945" maxlength="4" value="{{ old('implementation_year') }}" autocomplete="off" data-mask="0000">
	                    </div>
	                </div>
	                <div class="col-sm-4">
	                	<a href="javascript:void(0)" class="btn btn-warning waves-effect" id="btn_add_implementation">ADD IMPLEMENTATION</a>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-offset-2 col-sm-10">
	            		<table id="implementation_post" class="table">
	            			@foreach($inventory->implementations as $row)
	            			<tr>
					    		<td><input type="hidden" name="implementation_post_id[]" value="{{ $row->implementation_id }}"><input type="text" name="implementation_post_name[]" class="form-control" value="{{ $row->implementation_month_name }}" readonly></td>
					    		<td><input type="text" name="implementation_post_year[]" class="form-control" value="{{ $row->pivot->year }}" readonly></td>
					    		<td><a href="javascript:void(0)" class="btn btn-danger btn-implementation-delete">Remove</a></td>
					    	</tr>
	            			@endforeach
	            		</table>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="sell_period_id" class="col-sm-2 control-label">Sell Period</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <select name="sell_period_id" id="sell_period_id" class="selectpicker" data-live-search="true" title="filled with month(s) of the inventory’s sell period">
                                @foreach ($sell_periods as $row)
                                	{!! $selected = '' !!}
								    <option value="{{ $row->sell_period_id }}" {{ $selected }}>{{ $row->sell_period_month_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                </div>
	                <div class="col-sm-2">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="sell_period_year" id="sell_period_year" placeholder="e.g 1945" maxlength="4" value="{{ old('sell_period_year') }}" autocomplete="off" data-mask="0000">
	                    </div>
	                </div>
	                <div class="col-sm-4">
	                	<a href="javascript:void(0)" class="btn btn-warning waves-effect" id="btn_add_sell_period">ADD SELL PERIOD</a>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-offset-2 col-sm-10">
	            		<table id="sell_period_post" class="table">
	            			@foreach($inventory->sellperiods as $row)
	            			<tr>
					    		<td><input type="hidden" name="sell_period_post_id[]" value="{{ $row->sell_period_id }}"><input type="text" name="sell_period_post_name[]" class="form-control" value="{{ $row->sell_period_month_name }}" readonly></td>
					    		<td><input type="text" name="sell_period_post_year[]" class="form-control" value="{{ $row->pivot->year }}" readonly></td>
					    		<td><a href="javascript:void(0)" class="btn btn-danger btn-sell-period-delete">Remove</a></td>
					    	</tr>
	            			@endforeach
	            		</table>
	            	</div>
	            </div>
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
	                <label for="inventory_planner_cost" class="col-sm-2 control-label">Cost</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_cost" id="inventory_planner_cost" placeholder="Cost" maxlength="20" value="" required="true">
	                    </div>
	                    @if ($errors->has('inventory_planner_cost'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_cost') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_inventory_planner_cost"></span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_media_cost_print" class="col-sm-2 control-label">Media Cost Print</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_media_cost_print" id="inventory_planner_media_cost_print" placeholder="Media Cost Print" maxlength="20" value="" required="true">
	                    </div>
	                    @if ($errors->has('inventory_planner_media_cost_print'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_media_cost_print') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_inventory_planner_media_cost_print"></span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_media_cost_other" class="col-sm-2 control-label">Media Cost Digital/Other</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_media_cost_other" id="inventory_planner_media_cost_other" placeholder="Media Cost Other" maxlength="20" value="" required="true">
	                    </div>
	                    @if ($errors->has('inventory_planner_media_cost_other'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_media_cost_other') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_inventory_planner_media_cost_other"></span>
	                </div>
	            </div> 
	            <div class="form-group">
	                <label for="inventory_planner_total_offering" class="col-sm-2 control-label">Total Offering</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_planner_total_offering" id="inventory_planner_total_offering" placeholder="Total Offering" maxlength="20" value="" required="true">
	                    </div>
	                    @if ($errors->has('inventory_planner_total_offering'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_total_offering') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_inventory_planner_total_offering"></span>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="" class="col-sm-2 control-label"></label>
	            	<div class="col-sm-4" align="right">
	            		<div class="fg-line">
	            			<a href="javascript:void(0)" class="btn btn-warning waves-effect" id="btn_add_offering">ADD OFFERING</a>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-offset-2 col-sm-10">
	            		<table id="offering_post" class="table">
	            			<thead>
	            				<tr>
	            					<th>Cost</th>
	            					<th>Media Cost Print</th>
	            					<th>Media Cost Digital/Other</th>
	            					<th>Total Offering</th>
	            				</tr>
	            			</thead>
	            			<tbody>	
		            			@foreach($inventory->costdetails as $row)
		            			<tr>  		
						    		<td><input type="text" name="offering_post_cost[]" class="form-control" value="{{ $row->inventory_planner_cost }}" readonly></td>
						    		<td><input type="text" name="offering_post_media_cost_print[]" class="form-control" value="{{ $row->inventory_planner_media_cost_print }}" readonly></td>
						    		<td><input type="text" name="offering_post_media_cost_other[]" class="form-control" value="{{ $row->inventory_planner_media_cost_other }}" readonly></td>
						    		<td><input type="text" name="offering_post_total_offering[]" class="form-control" value="{{ $row->inventory_planner_total_offering }}" readonly></td>
						    		<td><a href="javascript:void(0)" class="btn btn-danger btn-offering-delete">Remove</a></td>
						    	</tr>
		            			@endforeach
	            		</tbody>
	            		</table>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_planner_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="inventory_planner_desc" id="inventory_planner_desc" class="form-control input-sm" placeholder="DESCRIPTION">{{ $inventory->inventory_planner_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('inventory_planner_desc'))
			                <span class="has-error help-block">
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
	                    <span>
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
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/inventory/inventoryplanner-create.js') }}"></script>
@endsection