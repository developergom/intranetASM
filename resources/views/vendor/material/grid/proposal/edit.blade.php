@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>GRID Proposal<small>Create New Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('grid/proposal/' . $proposal->grid_proposal_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
	            <div class="form-group">
	                <label for="grid_proposal_name" class="col-sm-2 control-label">Proposal Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="grid_proposal_name" id="grid_proposal_name" placeholder="Proposal Name" required="true" maxlength="100" value="{{ $proposal->grid_proposal_name }}">
	                    </div>
	                    @if ($errors->has('grid_proposal_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('grid_proposal_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="grid_proposal_deadline" class="col-sm-2 control-label">Deadline</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm date-picker" name="grid_proposal_deadline" id="grid_proposal_deadline" placeholder="Deadline" required="true" maxlength="10" value="{{ $deadline }}">
	                    </div>
	                    @if ($errors->has('grid_proposal_deadline'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('grid_proposal_deadline') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="grid_proposal_desc" class="col-sm-2 control-label">Brief</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="grid_proposal_desc" id="grid_proposal_desc" class="form-control input-sm" placeholder="Description">{{ $proposal->grid_proposal_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('grid_proposal_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('grid_proposal_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="pics" class="col-sm-2 control-label">PIC</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="pics" id="pics" class="selectpicker" data-live-search="true">
	                        @foreach($pics as $row)
	                        	@if($row->user_id == $proposal->pic_1)
	                        		<option value="{{ $row->user_id }}" selected>{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
	                        	@else
	                        		<option value="{{ $row->user_id }}">{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
	                        	@endif
	                        @endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('pics'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('pics') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="dropzone" id="uploadFileArea">
	                        	
	                        </div>
	                    </div>
	                    <span class="help-block">
		                    <strong>Max filesize: 10 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
		                </span>
	                </div>
	            </div>
	            @include('vendor.material.grid.proposal.history')
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('grid/proposal') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/grid/proposal-create.js') }}"></script>
@endsection