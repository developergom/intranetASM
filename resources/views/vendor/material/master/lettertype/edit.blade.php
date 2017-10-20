@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Letter Types Management<small>Edit Letter Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/lettertype/'.$lettertype->letter_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="letter_type_code" class="col-sm-2 control-label">Code</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="letter_type_code" id="letter_type_code" placeholder="Letter Type Code" required="true" maxlength="5" value="{{ $lettertype->letter_type_code }}">
	                    </div>
	                    @if ($errors->has('letter_type_code'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('letter_type_code') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="letter_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="letter_type_name" id="letter_type_name" placeholder="Letter Type Name" required="true" maxlength="100" value="{{ $lettertype->letter_type_name }}">
	                    </div>
	                    @if ($errors->has('letter_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('letter_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="letter_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="letter_type_desc" id="letter_type_desc" class="form-control input-sm" placeholder="Description">{{ $lettertype->letter_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('letter_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('letter_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/lettertype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection