@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Media Category Management<small>Create New Media Category</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/mediacategory') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="media_category_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="media_category_name" id="media_category_name" placeholder="Media Category Name" required="true" maxlength="100" value="{{ old('media_category_name') }}">
	                    </div>
	                    @if ($errors->has('media_category_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_category_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="media_category_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="media_category_desc" id="media_category_desc" class="form-control input-sm" placeholder="Description">{{ old('media_category_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('media_category_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('media_category_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/mediacategory') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection