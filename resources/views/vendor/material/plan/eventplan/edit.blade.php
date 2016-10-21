@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Program Plans<small>Edit Program Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('plan/eventplan/' . $eventplan->event_plan_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
        			<label for="event_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="event_type_id" id="event_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($eventtypes as $row)
	        						{!! $selected = '' !!}
	        						@if($row->event_type_id == $eventplan->event_type_id)
	        							{!! $selected = 'selected' !!}
	        						@endif
	        						<option value="{{ $row->event_type_id }}" {{ $selected }}>{{ $row->event_type_name }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('event_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('event_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="event_plan_name" class="col-sm-2 control-label">Program Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="event_plan_name" id="event_plan_name" placeholder="Program Plan Name" required="true" maxlength="100" value="{{ $eventplan->event_plan_name }}">
	                    </div>
	                    @if ($errors->has('event_plan_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="event_plan_desc" id="event_plan_desc" class="form-control input-sm" placeholder="Description">{{ $eventplan->event_plan_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('event_plan_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_viewer" class="col-sm-2 control-label">Estimated Viewer/Guest (number only)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="event_plan_viewer" id="event_plan_viewer" placeholder="Estimated Viewer/Guest" required="true" maxlength="15" value="{{ $eventplan->event_plan_viewer }}">
	                    </div>
	                    @if ($errors->has('event_plan_viewer'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_viewer') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
        			<label for="location_id" class="col-sm-2 control-label">Location</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="location_id" id="location_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($locations as $row)
	        						{!! $selected = '' !!}
	        						@if($row->location_id == $eventplan->location_id)
	        							{!! $selected = 'selected' !!}
	        						@endif
	        						<option value="{{ $row->location_id }}" {{ $selected }}>{{ $row->location_name . ' - ' . $row->location_city }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('location_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('location_id') }}</strong>
		                </span>
		            @endif
        		</div>
	            <div class="form-group">
	                <label for="implementation_id" class="col-sm-2 control-label">Implementation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="implementation_id[]" id="implementation_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($implementations as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($eventplan->implementations as $implementation)
                                		@if($implementation->implementation_id==$row->implementation_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
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
	                <label for="event_plan_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="event_plan_year" id="event_plan_year" placeholder="Program Plan Year" required="true" maxlength="4" value="{{ $eventplan->event_plan_year }}">
	                    </div>
	                    @if ($errors->has('event_plan_year'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_year') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="event_plan_deadline" id="event_plan_deadline" placeholder="e.g 17/08/1945" required="true" maxlength="10" value="{{ $event_plan_deadline }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                    @if ($errors->has('event_plan_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('event_plan_deadline') }}</strong>
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
                                	@foreach ($eventplan->medias as $media)
                                		@if($media->media_id==$row->media_id)
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
	                <label for="history" class="col-sm-2 control-label">History</label>
	                <div class="col-sm-10">
	                    <div class="timeline">
                        @foreach($eventplan->eventplanhistories as $key => $value)
                        	<div class="t-view" data-tv-type="text">
                                <div class="tv-header media">
                                    <a href="#" class="tvh-user pull-left">
                                        <img class="img-responsive" src="{{ url('img/avatar/' . $value->created_by->user_avatar) }}" alt="$value->created_by->user_avatar">
                                    </a>
                                    <div class="media-body p-t-5">
                                        <strong class="d-block">{{ $value->created_by->user_firstname . ' ' . $value->created_by->user_lastname }}</strong>
                                        <small class="c-gray">{{ $value->created_at }}</small>
                                    </div>
                                </div>
                                <div class="tv-body">
									<p>
										{{ $value->event_plan_history_text }}
									</p>
									<div class="clearfix"></div>
									<ul class="tvb-stats">
										<li class="tvbs-likes">{{ $value->approvaltype->approval_type_name }}</li>
									</ul>
                                </div>
                            </div>
                        @endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('plan/eventplan') }}" class="btn btn-danger btn-sm">Back</a>
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
<script src="{{ url('js/plan/eventplan-edit.js') }}"></script>
@endsection