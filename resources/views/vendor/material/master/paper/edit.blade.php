@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Paper Types Management<small>Edit Paper Type</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/paper/' . $paper->paper_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="paper_name" class="col-sm-2 control-label">Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="paper_name" id="paper_name" placeholder="Paper Name" required="true" maxlength="100" value="{{ $paper->paper_name }}">
	                    </div>
	                    @if ($errors->has('paper_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('paper_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="unit_id" class="col-sm-2 control-label">Unit</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="unit_id" id="unit_id" class="selectpicker" data-live-search="true" required="true">
                                @foreach ($unit as $row)
                                	{!! $selected = '' !!}
                                	@if($row->unit_id==$paper->unit_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->unit_id }}" {{ $selected }}>{{ $row->unit_name . ' (' . $row->unit_code . ')' }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('unit_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('unit_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="paper_width" class="col-sm-2 control-label">Width</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="paper_width" id="paper_width" placeholder="Paper Width" required="true" maxlength="10" value="{{ $paper->paper_width }}">
	                    </div>
	                    @if ($errors->has('paper_width'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('paper_width') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="paper_length" class="col-sm-2 control-label">Length</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="paper_length" id="paper_length" placeholder="Paper Length" required="true" maxlength="10" value="{{ $paper->paper_length }}">
	                    </div>
	                    @if ($errors->has('paper_length'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('paper_length') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="paper_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="paper_desc" id="paper_desc" class="form-control input-sm" placeholder="Description">{{ $paper->paper_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('paper_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('paper_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/paper') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection