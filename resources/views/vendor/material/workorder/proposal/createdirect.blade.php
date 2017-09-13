@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Proposal<small>Submit Direct Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="proposal_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="proposal_type_id" id="proposal_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($proposal_types as $row)
	        						{!! $selected = '' !!}
                                	@if($inventoryplanner->proposal_type_id==$row->proposal_type_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
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
	                <label for="proposal_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_name" id="proposal_name" placeholder="PROPOSAL NAME" required="true" maxlength="200" value="{{ $inventoryplanner->inventory_planner_title }}">
	                    </div>
	                    @if ($errors->has('proposal_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="industry_id" class="col-sm-2 control-label">Industry</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="industry_id[]" id="industry_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($industries as $row)
                                	{!! $selected = '' !!}
                                	@if(old('industry_id'))
	                                	@foreach (old('industry_id') as $key => $value)
	                                		@if($value==$row->industry_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('industry_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('industry_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_deadline" id="proposal_deadline" placeholder="Deadline" required="true" maxlength="100" value="{{ old('proposal_deadline') }}" readonly="true">
	                    </div>
	                    @if ($errors->has('proposal_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_id" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id[]" id="client_id" class="selectpicker with-ajax" data-live-search="true" multiple required="true">
                                
                            </select>
	                    </div>
	                    @if ($errors->has('client_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_contact_id" class="col-sm-2 control-label">Contact</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_contact_id[]" id="client_contact_id" class="selectpicker" data-live-search="true" multiple required="true">
                            </select>
	                    </div>
	                    @if ($errors->has('client_contact_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_contact_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="brand_id" class="col-sm-2 control-label">Brand</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="brand_id" id="brand_id" class="selectpicker" data-live-search="true" required="true">
                            </select>
	                    </div>
	                    @if ($errors->has('brand_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('brand_id') }}</strong>
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
	            	<label for="inventory_planner_name" class="col-sm-2 control-label">Inventory Planner</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<a href="{{ url('inventory/inventoryplanner/' . $inventoryplanner->inventory_planner_id) }}" target="_blank" title="Click to View"><span class="badge">{{ $inventoryplanner->inventory_planner_title . ' created by ' . $inventoryplanner->created_by->user_firstname . ' ' . $inventoryplanner->created_by->user_lastname }}</span></a>
	            		</div>
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
@endsection

@section('customjs')
<script src="{{ url('js/workorder/proposal-create-direct.js') }}"></script>
@endsection