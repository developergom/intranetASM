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
	                        <input type="text" class="form-control input-sm" name="media_code" id="media_code" placeholder="Media Code" required="true" maxlength="12" value="{{ $media->media_code }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_name" id="media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ $media->media_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" name="media_group_id" id="media_group_id" placeholder="Media Group" required="true" maxlength="100" value="{{ $media->mediagroup->media_group_name . ' (' . $media->mediagroup->media_group_code . ')' }}" disabled="true">
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
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/media') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection