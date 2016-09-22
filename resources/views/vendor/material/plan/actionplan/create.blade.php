@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
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
	        				<select name="action_type_id" id="action_type_id" class="selectpicker" data-live-search="true" required="true">
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
	                <label for="action_plan_startdate" class="col-sm-2 control-label">Start Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="action_plan_startdate" id="action_plan_startdate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('action_plan_startdate') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('action_plan_startdate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_startdate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_enddate" class="col-sm-2 control-label">End Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="action_plan_enddate" id="action_plan_enddate" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ old('action_plan_enddate') }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('action_plan_enddate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_enddate') }}</strong>
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
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="selectpicker" data-live-search="true" multiple required="true">
	                        	<!-- <option value=""></option> -->
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
	                <label for="media_edition_id" class="col-sm-2 control-label">Media Edition</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_edition_id[]" id="media_edition_id" class="selectpicker" data-live-search="true"	 multiple>
	                        	<!-- <option value=""></option> -->
                                @foreach ($mediaeditions as $row)
                                	{!! $selected = '' !!}
                                	@if(old('media_edition_id'))
	                                	@foreach (old('media_edition_id') as $key => $value)
	                                		@if($value==$row->media_edition_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->media_edition_id }}" {{ $selected }}>{{ $row->media->media_name .' - '. $row->media_edition_no }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_edition_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_edition_id') }}</strong>
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
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/plan/actionplan-create.js') }}"></script>
@endsection