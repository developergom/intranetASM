@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Creative Formats Management<small>Edit Creative Format</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/creativeformat/'.$creativeformat->creative_format_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="creative_format_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="creative_format_name" id="creative_format_name" placeholder="Action Type Name" required="true" maxlength="100" value="{{ $creativeformat->creative_format_name }}">
	                    </div>
	                    @if ($errors->has('creative_format_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('creative_format_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="creative_format_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="creative_format_desc" id="creative_format_desc" class="form-control input-sm" placeholder="Description">{{ $creativeformat->creative_format_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('creative_format_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('creative_format_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/creativeformat') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection