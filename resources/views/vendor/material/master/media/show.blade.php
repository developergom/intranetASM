@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Media Management<small>View Media</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="media_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="hidden" name="_media_id" value="{{ $media->media_id }}">
	                        <input type="text" class="form-control input-sm" name="media_code" id="media_code" placeholder="Media Code" required="true" maxlength="12" value="{{ $media->media_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_name" id="_media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ $media->media_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="publisher_id" class="col-sm-2 control-label">Publisher</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="publisher_id" id="publisher_id" placeholder="Publisher" required="true" maxlength="100" value="{{ $media->mediagroup->publisher->publisher_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="media_group_id" id="media_group_id" placeholder="Media Group" required="true" maxlength="100" value="{{ $media->mediagroup->media_group_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_category_id" class="col-sm-2 control-label">Category</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="media_group_id" id="media_group_id" placeholder="Media Group" required="true" maxlength="100" value="{{ $media->mediacategory->media_category_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_circulation" class="col-sm-2 control-label">Circulation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_circulation" id="_media_circulation" placeholder="Media Circulation" maxlength="100" value="{{ number_format($media->media_circulation) }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_desc" class="col-sm-2 control-label">Logo</label>
	                <div class="col-sm-10">
	                	<img src="{{ url('/img/media/logo/' . $media->media_logo) }}" class="img" width="200">
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="media_desc" id="media_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $media->media_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12">
	            		<div class="table-responsive">
					        <table id="grid-data" class="table table-hover">
					            <thead>
					                <tr>
					                    <th data-column-id="media_edition_no" data-order="asc">Edition No</th>
					                    <th data-column-id="media_edition_publish_date" data-converter="datetime" data-order="asc">Publish Date</th>
					                    <th data-column-id="media_edition_deadline_date" data-converter="datetime" data-order="asc">Deadline</th>
					                    @can('Media Management-Update')
					                        @can('Media Management-Delete')
					                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
					                        @else
					                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
					                        @endcan
					                    @else
					                        @can('Media Management-Delete')
					                            <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
					                        @else
					                            <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
					                        @endcan
					                    @endcan
					                </tr>
					            </thead>
					            <tbody>
					            </tbody>
					        </table>
					    </div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	@can('Media Management-Create')
	                    <a href="javascript:void(0)" class="btn btn-primary btn-sm waves-effect command-add-edition" data-row-media="{{ $media->media_name }}" data-row-id="{{ $media->media_id }}">Add Edition</a>
	                    @endcan
	                    <a href="{{ url('master/media') }}" class="btn btn-danger btn-sm waves-effect">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>

   	@include('vendor.material.master.media.modal')
@endsection

@section('vendorjs')
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/mediaedition-list.js') }}"></script>
<script src="{{ url('js/master/mediaedition.js') }}"></script>
@endsection