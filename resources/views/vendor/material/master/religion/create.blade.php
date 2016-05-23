@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Religion Management<small>Create New Religion</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/religion') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="religion_name" class="col-sm-2 control-label">Religion Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="religion_name" id="religion_name" placeholder="Religion Name" required="true" maxlength="100" value="{{ old('religion_name') }}">
	                    </div>
	                    @if ($errors->has('religion_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('religion_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/religion') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection