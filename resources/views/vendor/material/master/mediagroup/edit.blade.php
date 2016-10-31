@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Media Group Management<small>Edit Media Group</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/mediagroup/'.$mediagroup->media_group_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="publisher_id" class="col-sm-2 control-label">Publisher</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="publisher_id" id="publisher_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($publishers as $row)
                                	{!! $selected = '' !!}
                                	@if($row->publisher_id==$mediagroup->publisher_id)
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
	                <label for="media_group_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_group_code" id="media_group_code" placeholder="Media Group Code" required="true" maxlength="5" value="{{ $mediagroup->media_group_code }}">
	                    </div>
	                    @if ($errors->has('media_group_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_group_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_group_name" id="media_group_name" placeholder="Media Group Name" required="true" maxlength="100" value="{{ $mediagroup->media_group_name }}">
	                    </div>
	                    @if ($errors->has('media_group_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_group_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_group_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="media_group_desc" id="media_group_desc" class="form-control input-sm" placeholder="Description">{{ $mediagroup->media_group_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('media_group_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_group_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/mediagroup') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection