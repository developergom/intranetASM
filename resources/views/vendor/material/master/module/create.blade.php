@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Module Management<small>Create New Module</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/module') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="module_url" class="col-sm-2 control-label">Module URL</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="module_url" id="module_url" placeholder="Module URL" required="true" maxlength="100" value="{{ old('module_url') }}">
	                    </div>
	                    @if ($errors->has('module_url'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('module_url') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="module_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="module_desc" id="module_desc" class="form-control input-sm" placeholder="Description">{{ old('module_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('module_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('module_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="action_id" class="col-sm-2 control-label">Action(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="action_id[]" id="action_id" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($actions as $row)
                                	{!! $selected = '' !!}
                                	@if(old('action_id'))
	                                	@foreach (old('action_id') as $key => $value)
	                                		@if($value==$row->action_id)
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row->action_id }}" {{ $selected }}>{{ $row->action_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('action_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('action_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/module') }}" class="btn btn-danger btn-sm">Back</a>
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

@section('customjs')
<script src="{{ url('js/master/module-create.js') }}"></script>
@endsection