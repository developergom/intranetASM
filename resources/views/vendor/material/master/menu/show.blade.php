@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Menu Management<small>View Menu</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="menu_name" class="col-sm-2 control-label">Menu Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="menu_name" id="menu_name" placeholder="Menu Name" required="true" maxlength="100" value="{{ $menu->menu_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="module_id" class="col-sm-2 control-label">URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<input type="text" class="form-control input-sm" placeholder="Module URL" required="true" maxlength="100" value="{{ $menu->module->module_url }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="menu_icon" class="col-sm-2 control-label">Icon</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <i class="{{ $menu->menu_icon }}"></i>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="menu_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="menu_desc" id="menu_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $menu->menu_desc }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="menu_parent" class="col-sm-2 control-label">Menu Structures</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	@foreach($parents as $key => $val)
	                        	@if($menu->menu_id == $key)
	                        		<b>{{ $val }}</b>
								@else
									{{ $val }}
	                        	@endif
	                        	<br/>
                        	@endforeach
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('master/menu') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
@endsection