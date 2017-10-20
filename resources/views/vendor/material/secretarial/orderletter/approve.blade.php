@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Order Letter<small>Approve Order Letter</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		@include('vendor.material.secretarial.orderletter.view')
	            <div class="form-group">
	                <label for="approval" class="col-sm-2 control-label">Approval</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <label class="radio radio-inline m-r-20">
	                            <input name="approval" value="1" type="radio" required>
	                            <i class="input-helper"></i>  
	                            Yes
	                        </label>
	                        <label class="radio radio-inline m-r-20">
	                            <input name="approval" value="0" type="radio" required>
	                            <i class="input-helper"></i>  
	                            No
	                        </label>
	                    </div>
	                </div>
	            </div>
	            @if($letter->flow_no=='2')
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
	            @endif
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
	                    <a href="{{ url('secretarial/letter') }}" class="btn btn-danger btn-sm">Back</a>
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
<script type="text/javascript">
	var myToken = $('meta[name="csrf-token"]').attr('content');
</script>
<script src="{{ url('js/app/general-upload.js') }}"></script>
@endsection