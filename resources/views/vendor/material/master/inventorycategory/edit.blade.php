@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Inventory Categories Management<small>Edit Inventory Category</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/inventorycategory/'.$inventorycategory->inventory_category_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="inventory_category_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="inventory_category_name" id="inventory_category_name" placeholder="Inventory Category Name" required="true" maxlength="100" value="{{ $inventorycategory->inventory_category_name }}">
	                    </div>
	                    @if ($errors->has('inventory_category_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_category_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="inventory_category_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="inventory_category_desc" id="inventory_category_desc" class="form-control input-sm" placeholder="Description">{{ $inventorycategory->inventory_category_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('inventory_category_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('inventory_category_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/inventorycategory') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection