@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Flow Groups Management<small>Edit Flow Group</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/flowgroup/' . $flowgroup->flow_group_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="flow_group_name" class="col-sm-2 control-label">Flow Group Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="flow_group_name" id="flow_group_name" placeholder="flow_group Name" required="true" maxlength="100" value="{{ $flowgroup->flow_group_name }}">
	                    </div>
	                    @if ($errors->has('flow_group_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_group_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="module_id" class="col-sm-2 control-label">URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="module_id" id="module_id" class="selectpicker" data-live-search="true" required="true">
                                @foreach ($modules as $row)
                                	{!! $selected = '' !!}
                                	@if($row->module_id == $flowgroup->module_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->module_id }}" {{ $selected }}>{{ $row->module_url }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('module_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('module_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="flow_group_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="flow_group_desc" id="flow_group_desc" class="form-control input-sm" placeholder="Description">{{ $flowgroup->flow_group_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('flow_group_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('flow_group_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/flowgroup') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection