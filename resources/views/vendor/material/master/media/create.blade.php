@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Media Management<small>Create New Media</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/media') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="media_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_code" id="media_code" placeholder="Media Code" required="true" maxlength="12" value="{{ old('media_code') }}">
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
	                        <input type="text" class="form-control input-sm" name="media_name" id="media_name" placeholder="Media Name" required="true" maxlength="100" value="{{ old('media_name') }}">
	                    </div>
	                    @if ($errors->has('media_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_id" class="col-sm-2 control-label">Group</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="media_group_id" id="media_group_id" class="chosen" required="true">
	                        	<option value=""></option>
                                @foreach ($mediagroup as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_group_id==old('media_group_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->media_group_id }}" {{ $selected }}>{{ $row->media_group_name . ' (' . $row->media_group_code . ')' }}</option>
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
	                        <select name="media_category_id" id="media_category_id" class="chosen" required="true">
	                        	<option value=""></option>
                                @foreach ($mediacategory as $row)
                                	{!! $selected = '' !!}
                                	@if($row->media_category_id==old('media_category_id'))
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
	                <label for="media_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="media_desc" id="media_desc" class="form-control input-sm" placeholder="Description">{{ old('media_desc') }}</textarea>
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
<script src="{{ url('js/chosen.jquery.js') }}"></script>
@endsection