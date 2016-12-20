@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Media Management<small>Edit Media</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/media/' . $media->media_id) }}" enctype="multipart/form-data">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="media_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_code" id="media_code" placeholder="Media Code" required="true" maxlength="12" value="{{ $media->media_code }}">
	                    </div>
	                    @if ($errors->has('media_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_name" id="media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ $media->media_name }}">
	                    </div>
	                    @if ($errors->has('media_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="publisher_id" class="col-sm-2 control-label">Publisher</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="publisher_id" id="publisher_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($publisher as $row)
                                	{!! $selected = '' !!}
                                	@if($row->publisher_id==$media->mediagroup->publisher->publisher_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->publisher_id }}" {{ $selected }}>{{ $row->publisher_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('publisher_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('publisher_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_group_id" id="media_group_id" class="selectpicker" data-live-search="true" required="true">
                                @foreach ($mediagroup as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_group_id==$media->media_group_id)
                                		{!! $selected = 'selected' !!}
                                		<option value="{{ $row->media_group_id }}" {{ $selected }}>{{ $row->media_group_name . ' (' . $row->media_group_code . ')' }}</option>
                                	@endif
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_group_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_group_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_category_id" class="col-sm-2 control-label">Category</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_category_id" id="media_category_id" class="selectpicker" data-live-search="true" required="true">
                                @foreach ($mediacategory as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_category_id==$media->media_category_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->media_category_id }}" {{ $selected }}>{{ $row->media_category_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('media_category_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_category_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_circulation" class="col-sm-2 control-label">Circulation</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_circulation" id="media_circulation" placeholder="Media Circulation ex: 50000" maxlength="10" value="{{ $media->media_circulation }}">
	                    </div>
	                    @if ($errors->has('media_circulation'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_circulation') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_desc" class="col-sm-2 control-label">Logo</label>
	                <div class="col-sm-10">
	                    <div class="fileinput fileinput-new" data-provides="fileinput">
	                    	<div class="thumbnail">
	                    		<img src="{{ url('/img/media/logo/' . $media->media_logo) }}" width="200" title="Current Logo">
	                    		<div class="caption">
	                    			<h6>Current Logo</h6>
	                    		</div>
	                    	</div>
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput"></div>
                            <div>
                                <span class="btn btn-info btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="media_logo">
                                </span>
                                <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                        <span class="help-block">
		                    Allowed File Types: *.jpg, *.jpeg, *.gif, *.png , Max Size: 2 MB
		                </span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="media_desc" id="media_desc" class="form-control input-sm" placeholder="Description">{{ $media->media_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('media_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/media') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/fileinput.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('js/master/media-create.js') }}"></script>
@endsection