@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Advertise Rate Types Management<small>Create New Advertise Rate Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/advertiseratetype') }}">
        		{{ csrf_field() }}
	            <div class="form-group">
	                <label for="advertise_rate_type_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="advertise_rate_type_name" id="advertise_rate_type_name" placeholder="Advertise Rate Type Name" required="true" maxlength="100" value="{{ old('advertise_rate_type_name') }}">
	                    </div>
	                    @if ($errors->has('advertise_rate_type_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_type_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="advertise_rate_required_fields" class="col-sm-2 control-label">Required Field</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<select name="advertise_rate_required_fields[]" id="advertise_rate_required_fields" class="selectpicker" data-live-search="true" multiple required="true">
                                @foreach ($cols as $row)
                                	{!! $selected = '' !!}
                                	@if(old('advertise_rate_required_fields'))
	                                	@foreach (old('advertise_rate_required_fields') as $key => $value)
	                                		@if($value==$row['key'])
	                                			{!! $selected = 'selected' !!}
	                                		@endif
	                                	@endforeach
                                	@endif
								    <option value="{{ $row['key'] }}" {{ $selected }}>{{ $row['text'] }}</option>
								@endforeach
                            </select>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="advertise_rate_type_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="advertise_rate_type_desc" id="advertise_rate_type_desc" class="form-control input-sm" placeholder="Description">{{ old('advertise_rate_type_desc') }}</textarea>
	                    </div>
	                    @if ($errors->has('advertise_rate_type_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('advertise_rate_type_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/advertiseratetype') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
@endsection