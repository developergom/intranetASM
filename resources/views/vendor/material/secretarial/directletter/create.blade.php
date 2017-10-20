@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Direct Letter<small>Create New Direct Letter</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('secretarial/directletter') }}">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="letter_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
        					<select name="letter_type_id" id="letter_type_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($lettertypes as $row)
                                	{!! $selected = '' !!}
                                	@if($row->letter_type_id==old('letter_type_id'))
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->letter_type_id }}" {{ $selected }}>{{ $row->letter_type_name . ' - ' . $row->letter_type_code }}</option>
								@endforeach
                            </select>
        				</div>
        			</div>
        		</div>
        		<div class="form-group">
	                <label for="letter_to" class="col-sm-2 control-label">Send To</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="letter_to" id="letter_to" placeholder="Send To" required="true" maxlength="100" value="{{ old('letter_to') }}">
	                    </div>
	                    @if ($errors->has('letter_to'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('letter_to') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="contract_id" class="col-sm-2 control-label">Contract</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="contract_id[]" id="contract_id" class="selectpicker with-ajax" data-live-search="true" multiple>
                            </select>
	                    </div>
	                </div>
	            </div>
	            @can('Direct Letter-Upload')
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="dropzone" id="uploadFileArea">
	                        	
	                        </div>
	                    </div>
	                    <span class="help-block">
		                    <strong>Max filesize: 200 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
		                </span>
	                </div>
	            </div>
	            @endcan
	            <div class="form-group">
	                <label for="letter_notes" class="col-sm-2 control-label">Notes</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="letter_notes" id="letter_notes" class="form-control input-sm" placeholder="Notes">{{ old('letter_notes') }}</textarea>
	                    </div>
	                    @if ($errors->has('letter_notes'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('letter_notes') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('secretarial/directletter') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/secretarial/orderletter-create.js') }}"></script>
<script src="{{ url('js/app/general-upload.js') }}"></script>
@endsection