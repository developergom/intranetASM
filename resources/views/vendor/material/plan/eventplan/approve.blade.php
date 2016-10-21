@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Program Plans<small>Program Plan Approval</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form"  method="POST" action="{{ url('plan/eventplan/approve/' . $eventplan->flow_no . '/' . $eventplan->event_plan_id) }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="event_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<input type="text" class="form-control input-sm" name="event_plan_type" id="event_plan_type" placeholder="Program Plan Type" disabled="true" maxlength="100" value="{{ $eventplan->eventtype->event_type_name }}">
	        			</div>
        			</div>
        		</div>
	            <div class="form-group">
	                <label for="event_plan_name" class="col-sm-2 control-label">Program Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="event_plan_name" id="event_plan_name" placeholder="Program Plan Name" disabled="true" maxlength="100" value="{{ $eventplan->event_plan_name }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="event_plan_desc" id="event_plan_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $eventplan->event_plan_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_viewer" class="col-sm-2 control-label">Estimated Viewer/Guest (number only)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="event_plan_viewer" id="event_plan_viewer" placeholder="Estimated Viewer/Guest" required="true" maxlength="15" disabled="true" value="{{ $eventplan->event_plan_viewer }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="location_id" class="col-sm-2 control-label">Location</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="location_id" id="location_id" placeholder="Location" required="true" maxlength="100" disabled="true" value="{{ $eventplan->location->location_name . ' - ' . $eventplan->location->location_city }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="implementation_id" class="col-sm-2 control-label">Implementation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($implementations as $row)
                            	@foreach ($eventplan->implementations as $implementation)
                            		@if($implementation->implementation_id==$row->implementation_id)
                            			<span class="badge">{{ $row->implementation_month_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_year" class="col-sm-2 control-label">Year</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="event_plan_year" id="event_plan_year" placeholder="Program Plan Year" required="true" maxlength="4" value="{{ $eventplan->event_plan_year }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="event_plan_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="event_plan_deadline" id="event_plan_deadline" placeholder="e.g 17/08/1945" disabled="true" maxlength="10" value="{{ $event_plan_deadline }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($medias as $row)
                            	@foreach ($eventplan->medias as $media)
                            		@if($media->media_id==$row->media_id)
                            			<span class="badge">{{ $row->media_name }}</span>
                            		@endif
                            	@endforeach
							@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Uploaded File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="row">
	                        	@foreach ($uploadedfiles as $uploadedfile)
	                        	<div class="col-sm-6 col-md-3">
	                        		<div class="thumbnail">
	                        			@if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
	                        			<img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
	                        			@else
	                        			<img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
	                        			@endif
	                        			<div class="caption">
	                        				<h4>{{ $uploadedfile->upload_file_name }}</h4>
	                        				<p>{{ $uploadedfile->upload_file_desc }}</p>
	                        				<div class="m-b-5">
	                        					@can('Program Plan-Download')
	                        					<a class="btn btn-sm btn-primary waves-effect" href="{{ url('download/file/' . $uploadedfile->upload_file_id) }}" role="button">Download File</a>
	                        					@endcan
	                        				</div>
	                        			</div>
	                        		</div>
	                        	</div>
	                        	@endforeach
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="created_by" class="col-sm-2 control-label">Created By</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" placeholder="Created By" disabled="true" maxlength="100" value="{{ $eventplan->created_by->user_firstname . ' ' . $eventplan->created_by->user_lastname }}">
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
	                <label for="approval" class="col-sm-2 control-label">Approval</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <label class="radio radio-inline m-r-20">
	                            <input name="approval" value="1" type="radio" required>
	                            <i class="input-helper"></i>  
	                            Yes
	                        </label>
	                        <label class="radio radio-inline m-r-20">
	                            <input name="approval" value="0" type="radio" required>
	                            <i class="input-helper"></i>  
	                            No
	                        </label>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="comment" class="col-sm-2 control-label">Comment</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="comment" id="comment" class="form-control input-sm" placeholder="Comment" required="true">{{ old('comment') }}</textarea>
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
@endsection

@section('customjs')

@endsection