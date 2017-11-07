@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Sources Management<small>Create New Inventory Source</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/inventorysource') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="inventory_source_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_source_name" id="inventory_source_name" placeholder="Inventory Source Name" required="true" maxlength="100" value="{{ old('inventory_source_name') }}">
	                    </div>
	                    @if ($errors->has('inventory_source_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_source_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_source_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="inventory_source_desc" id="inventory_source_desc" class="form-control input-sm" placeholder="Description">{{ old('inventory_source_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('inventory_source_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_source_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/inventorysource') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection