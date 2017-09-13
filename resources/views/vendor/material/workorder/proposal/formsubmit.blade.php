@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Proposal<small>Submit Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		@include('vendor.material.workorder.proposal.view')
	            <div class="form-group">
	                <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <div class="dropzone" id="uploadFileArea">
	                        	
	                        </div>
	                    </div>
	                    <span>
		                    <strong>Max filesize: 10 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
		                </span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="comment" class="col-sm-2 control-label">Message</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="comment" id="comment" class="form-control input-sm" placeholder="MESSAGE">{{ old('comment') }}</textarea>
	                    </div>
	                </div>
	                @if ($errors->has('comment'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('comment') }}</strong>
		                </span>
		            @endif
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('workorder/proposal') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/dropzone.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/workorder/proposal-submit.js') }}"></script>
@endsection