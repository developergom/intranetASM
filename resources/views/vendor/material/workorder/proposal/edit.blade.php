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
        <div class="card-header"><h2>Proposal<small>Edit Proposal Brief</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('workorder/proposal/' . $proposal->proposal_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
        			<label for="proposal_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="proposal_type_id" id="proposal_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($proposal_types as $row)
	        						{!! $selected = '' !!}
                                	@if($proposal->proposal_type_id==$row->proposal_type_id)
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
	                        <input type="text" class="form-control input-sm" name="proposal_name" id="proposal_name" placeholder="Proposal Name" required="true" maxlength="200" value="{{ $proposal->proposal_name }}">
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
                                	@foreach ($proposal->industries as $key => $value)
                                		@if($value->industry_id==$row->industry_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
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
	                        <input type="text" class="form-control input-sm" name="proposal_deadline" id="proposal_deadline" placeholder="Deadline" required="true" maxlength="100" value="{{ $proposal->proposal_deadline }}" readonly="true">
	                    </div>
	                    @if ($errors->has('proposal_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_budget" class="col-sm-2 control-label">Budget</label>
	                <div class="col-sm-3">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="proposal_budget" id="proposal_budget" placeholder="Budget" required="true" maxlength="17" value="{{ $proposal->proposal_budget }}">
	                    </div>
	                    @if ($errors->has('proposal_budget'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_budget') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-7">
	                	<span class="badge" id="result_proposal_budget">{{ number_format($proposal->proposal_budget) }}</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_id" class="col-sm-2 control-label">Client</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="client_id" id="client_id" class="selectpicker with-ajax" data-live-search="true" required="true">
                                <option value="{{ $proposal->client_id }}" selected>{{ $proposal->client->client_name }}</option>
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
	                        @foreach($proposal->client_contacts as $row)
	                        	<option value="{{ $row->client_contact_id }}" selected>{{ $row->client_contact_name . ' - ' . $row->client_contact_position }}</option>
	                        @endforeach
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
	                        	<option value="{{ $proposal->brand_id }}" selected>{{ $proposal->brand->brand_name }}</option>
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
                                	@foreach ($proposal->medias as $key => $value)
                                		@if($value->media_id==$row->media_id)
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
	            </div><!-- 
	            <div class="form-group">
	                <label for="inventory_planner_id" class="col-sm-2 control-label">Inventory Planner</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="inventory_planner_id[]" id="inventory_planner_id" class="selectpicker with-ajax" data-live-search="true" multiple>
                                
                            </select>
	                    </div>
	                    @if ($errors->has('inventory_planner_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_planner_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div> -->
	            <div class="form-group">
	                <label for="proposal_desc" class="col-sm-2 control-label">Creative Brief</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="proposal_desc" id="proposal_desc" class="form-control input-sm" placeholder="Description">{{ $proposal->proposal_desc }}</textarea>
	                    </div>
	                    <span class="help-block">
	                    	1. What is the BRAND? <br/>
							2. Background-WHAT WE SHOULD KNOW.  <br/>
							3. Advertising Objective-WHAT WE WANT TO HAPPEN  <br/>
							4. Target Audience-WHO TO SELL  <br/>
							5. Positioning. HOW TO SELL. <br/>
							6. Desire Response  <br/>
							7. Tonality & Manner (Execution)
	                    </span>
	                    @if ($errors->has('proposal_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_desc') }}</strong>
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
	                    <a href="{{ url('workorder/proposal') }}" class="btn btn-danger btn-sm">Back</a>
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
<script src="{{ url('js/workorder/proposal-create.js') }}"></script>
@endsection