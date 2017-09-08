@extends('vendor.material.layouts.app')

@section('vendorcss')
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Studios Management<small>Edit Studio</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/studio/' . $studio->studio_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="studio_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="studio_name" id="studio_name" placeholder="Studio Name" required="true" maxlength="100" value="{{ $studio->studio_name }}">
	                    </div>
	                    @if ($errors->has('studio_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('studio_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="studio_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="studio_desc" id="studio_desc" class="form-control input-sm" placeholder="Description">{{ $studio->studio_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('studio_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('studio_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/studio') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection