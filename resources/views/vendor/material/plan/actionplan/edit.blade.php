@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Action Plans<small>Edit Action Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('plan/actionplan/' . $actionplan->action_plan_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="action_plan_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_plan_title" id="action_plan_title" placeholder="Action Plan Title" required="true" maxlength="100" value="{{ $actionplan->action_plan_title }}">
	                    </div>
	                    @if ($errors->has('action_plan_title'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_title') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_desc" class="col-sm-2 control-label">Theme Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="action_plan_desc" id="action_plan_desc" class="form-control input-sm" placeholder="Theme Description">{{ $actionplan->action_plan_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('action_plan_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_rubric_desc" class="col-sm-2 control-label">Rubric Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="action_plan_rubric_desc" id="action_plan_rubric_desc" class="form-control input-sm" placeholder="Rubric Description">{{ $actionplan->action_plan_rubric_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('action_plan_rubric_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_rubric_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Media Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_group_id[]" id="media_group_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($mediagroups as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($actionplan->mediagroups as $mediagroup)
                                		@if($mediagroup->media_group_id==$row->media_group_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option value="{{ $row->media_group_id }}" {{ $selected }}>{{ $row->media_group_name }}</option>
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
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($actionplan->medias as $media)
                                		@if($media->media_id==$row->media_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option label="{{ $row->media_category_id }}" value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
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
	            <div class="form-group" id="media_edition_id_container">
	                <label for="media_edition_id" class="col-sm-2 control-label">Media Edition (Print Media)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_edition_id[]" id="media_edition_id" class="selectpicker" data-live-search="true" multiple>
                                @foreach ($mediaeditions as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($actionplan->mediaeditions as $mediaedition)
                                		@if($mediaedition->media_edition_id==$row->media_edition_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
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
	            <div class="form-group" id="action_plan_pages_container">
	                <label for="action_plan_pages" class="col-sm-2 control-label">Total Pages (Print Media)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_plan_pages" id="action_plan_pages" placeholder="Total Pages (numeric)" maxlength="20" value="{{ $actionplan->action_plan_pages }}">
	                    </div>
	                    @if ($errors->has('action_plan_pages'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_pages') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="action_plan_startdate_container">
	                <label for="action_plan_startdate" class="col-sm-2 control-label">Start Date (Digital Media)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="action_plan_startdate" id="action_plan_startdate" placeholder="e.g 17/08/1945" maxlength="10" value="{{ $startdate }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('action_plan_startdate'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_startdate') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group" id="action_plan_views_container">
	                <label for="action_plan_views" class="col-sm-2 control-label">Total Views (Digital Media)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_plan_views" id="action_plan_views" placeholder="Total Views (numeric)" maxlength="20" value="{{ $actionplan->action_plan_views }}">
	                    </div>
	                    @if ($errors->has('action_plan_views'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_plan_views') }}</strong>
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
<script src="{{ url('js/plan/actionplan-edit.js') }}"></script>
@endsection