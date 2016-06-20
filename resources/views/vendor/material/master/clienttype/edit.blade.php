@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Client Types Management<small>Edit Client Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/clienttype/'.$clienttype->client_type_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="client_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="client_type_name" id="client_type_name" placeholder="Client Type Name" required="true" maxlength="100" value="{{ $clienttype->client_type_name }}">
	                    </div>
	                    @if ($errors->has('client_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="client_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="client_type_desc" id="client_type_desc" class="form-control input-sm" placeholder="Description">{{ $clienttype->client_type_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('client_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('client_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/clienttype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection