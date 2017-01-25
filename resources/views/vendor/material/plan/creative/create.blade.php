@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Creative Plans<small>Create New Creative Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('plan/creativeplan') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="creative_format_id" class="col-sm-2 control-label">Format</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="creative_format_id" id="creative_format_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($creativeformats as $row)
	        						<option value="{{ $row->creative_format_id }}">{{ $row->creative_format_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('creative_format_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('creative_format_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="creative_name" class="col-sm-2 control-label">Creative Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_name" id="creative_name" placeholder="Creative Plan Name" required="true" maxlength="100" value="{{ old('creative_name') }}">
	                    </div>
	                    @if ($errors->has('creative_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('creative_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
        			<label for="media_category_id" class="col-sm-2 control-label">Category</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="media_category_id" id="media_category_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($mediacategories as $row)
	        						<option value="{{ $row->media_category_id }}">{{ $row->media_category_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('media_category_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('media_category_id') }}</strong>
		                </span>
		            @endif
        		</div>
        		<div class="form-group">
        			<label for="unit_id" class="col-sm-2 control-label">Unit</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="unit_id" id="unit_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($units as $row)
	        						<option value="{{ $row->unit_id }}">{{ $row->unit_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('unit_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('unit_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="creative_width" class="col-sm-2 control-label">Width</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_width" id="creative_width" placeholder="Width" required="true" maxlength="10" value="{{ old('creative_width') }}">
	                    </div>
	                    @if ($errors->has('creative_width'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('creative_width') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="creative_height" class="col-sm-2 control-label">Height</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_height" id="creative_height" placeholder="Height" required="true" maxlength="10" value="{{ old('creative_height') }}">
	                    </div>
	                    @if ($errors->has('creative_height'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('creative_height') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="creative_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="creative_desc" id="creative_desc" class="form-control input-sm" placeholder="Description">{{ old('creative_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('creative_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('creative_desc') }}</strong>
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
	                    <a href="{{ url('plan/creativeplan') }}" class="btn btn-danger btn-sm">Back</a>
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
<script src="{{ url('js/plan/creative-create.js') }}"></script>
@endsection