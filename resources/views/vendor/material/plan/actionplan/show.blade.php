@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Action Plans<small>View Action Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="action_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="action_type_id" id="action_type_id" class="chosen" disabled="true">
	        					@foreach($actiontypes as $row)
	        						@if($actionplan->action_type_id == $row->action_type_id)
	        							<option value="{{ $row->action_type_id }}" selected>{{ $row->action_type_name }}</option>
	        						@endif
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        		</div>
	            <div class="form-group">
	                <label for="action_plan_title" class="col-sm-2 control-label">Title</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="action_plan_title" id="action_plan_title" placeholder="Action Plan Title" disabled="true" maxlength="100" value="{{ $actionplan->action_plan_title }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_startdate" class="col-sm-2 control-label">Start Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="action_plan_startdate" id="action_plan_startdate" placeholder="e.g 17/08/1945" disabled="true" maxlength="10" value="{{ $startdate }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_enddate" class="col-sm-2 control-label">End Date</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm input-mask" name="action_plan_enddate" id="action_plan_enddate" placeholder="e.g 17/08/1945" disabled="true" maxlength="10" value="{{ $enddate }}" autocomplete="off" data-mask="00/00/0000">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_plan_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="action_plan_desc" id="action_plan_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $actionplan->action_plan_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_id[]" id="media_id" class="chosen" multiple required="true" disabled="true" placeholder="Media Edition">
                                @foreach ($medias as $row)
                                	{!! $selected = '' !!}
                                	@foreach ($actionplan->medias as $media)
                                		@if($media->media_id==$row->media_id)
                                			{!! $selected = 'selected' !!}
                                		@endif
                                	@endforeach
								    <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_edition_id" class="col-sm-2 control-label">Media Edition</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_edition_id[]" id="media_edition_id" class="chosen" multiple disabled="true" placeholder="Media Edition">
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
	                        					<!-- <a class="btn btn-sm btn-primary waves-effect" href="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" role="button">Download File</a> -->
	                        					<a class="btn btn-sm btn-primary waves-effect" href="{{ url('download/file/' . $uploadedfile->upload_file_id) }}" role="button">Download File</a>
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
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('plan/actionplan') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
@endsection

@section('customjs')

@endsection