@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Creative Plans<small>View Creative Plan</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="creative_format_id" class="col-sm-2 control-label">Format</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<input type="text" class="form-control input-sm" name="creative_format_id" id="creative_format_id" placeholder="Creative Format" required="true" maxlength="100" value="{{ $creative->creativeformat->creative_format_name }}" readonly="true">
	        			</div>
        			</div>
        		</div>
	            <div class="form-group">
	                <label for="creative_name" class="col-sm-2 control-label">Creative Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_name" id="creative_name" placeholder="Creative Plan Name" required="true" maxlength="100" value="{{ $creative->creative_name }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
        			<label for="media_category_id" class="col-sm-2 control-label">Category</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<input type="text" class="form-control input-sm" name="media_category_id" id="media_category_id" placeholder="Category" required="true" maxlength="100" value="{{ $creative->mediacategory->media_category_name }}" readonly="true">
	        			</div>
        			</div>
        		</div>
	            <div class="form-group">
	                <label for="creative_width" class="col-sm-2 control-label">Width</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_width" id="creative_width" placeholder="Width" required="true" maxlength="10" value="{{ $creative->creative_width .' '. $creative->unit->unit_code }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="creative_height" class="col-sm-2 control-label">Height</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_height" id="creative_height" placeholder="Height" required="true" maxlength="10" value="{{ $creative->creative_height .' '. $creative->unit->unit_code }}" readonly="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="creative_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        {!! $creative->creative_desc !!}
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_id" class="col-sm-2 control-label">Media</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
                            @foreach ($medias as $row)
                            	@foreach ($creative->medias as $media)
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
	                        					@can('Creative Plan-Download')
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
	                        <input type="text" class="form-control input-sm" placeholder="Created By" readonly="true" maxlength="100" value="{{ $creative->created_by->user_firstname . ' ' . $creative->created_by->user_lastname }}">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="history" class="col-sm-2 control-label">History</label>
	                <div class="col-sm-10">
	                    <div class="timeline">
                        @foreach($creative->creativehistories as $key => $value)
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
										{!! $value->creative_history_text !!}
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
@endsection

@section('customjs')

@endsection