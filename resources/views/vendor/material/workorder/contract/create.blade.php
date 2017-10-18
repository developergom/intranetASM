@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Contract<small>Create Contract</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('workorder/contract') }}">
        		{{ csrf_field() }}
            <input type="hidden" name="proposal_id" value="{{ $proposal->proposal_id }}">
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
                <label for="contract_notes" class="col-sm-2 control-label">Notes</label>
                <div class="col-sm-10">
                  <div class="fg-line">
                    <textarea name="contract_notes" id="contract_notes" class="form-control input-sm" placeholder="Contract Notes">{{ old('contract_notes') }}</textarea>
                  </div>
                  @if ($errors->has('contract_notes'))
                        <span class="help-block">
                            <strong>{{ $errors->first('contract_notes') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <hr/>
              <div class="form-group">
                <label for="messages" class="col-sm-2 control-label">Messages</label>
                <div class="col-sm-10">
                  <div class="fg-line">
                    <textarea name="messages" id="messages" class="form-control input-sm" placeholder="Messages">{{ old('messages') }}</textarea>
                  </div>
                  @if ($errors->has('messages'))
                        <span class="help-block">
                            <strong>{{ $errors->first('messages') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    <a href="{{ url('workorder/contract') }}" class="btn btn-danger btn-sm">Back</a>
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
<script src="{{ url('js/workorder/contract-create.js') }}"></script>
@endsection