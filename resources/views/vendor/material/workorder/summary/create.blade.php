@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('vendor/handsontable/handsontable.full.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('customcss')
<style type="text/css">
  .handsontable .htCore .htDimmed {
      background-color: #CCCCCC;
      font-style: italic;
  }
</style>
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Summary<small>Create Summary</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('workorder/summary') }}">
        		{{ csrf_field() }}
            <input type="hidden" name="contract_id" value="{{ $contract->contract_id }}">
        		@include('vendor.material.workorder.contract.view')
            <hr/>
              <div class="form-group">
                  <label for="top_type" class="col-sm-2 control-label">Term of Payment</label>
                  <div class="col-sm-10">
                      <div class="fg-line">
                        <div class="radio m-b-15">
                          <label>
                              <input type="radio" name="top_type" value="bulk" {{ (old('top_type')=='bulk') ? 'checked' : '' }}>
                              <i class="input-helper"></i>
                              Bulk (Please insert All Termin column with "1")
                            </label>
                        </div>
                        <div class="radio m-b-15">
                          <label>
                              <input type="radio" name="top_type" value="termin" {{ (old('top_type')=='termin') ? 'checked' : '' }}>
                              <i class="input-helper"></i>
                              Termin (Please insert Termin column with "1" - Number of Termin)
                            </label>
                        </div>
                        <div class="radio m-b-15">
                          <label>
                              <input type="radio" name="top_type" value="insertion" {{ (old('top_type')=='insertion') ? 'checked' : '' }}>
                              <i class="input-helper"></i>
                              Insertion (Please insert Termin column with "1" - Number of Insertion)
                            </label>
                        </div>
                      </div>
                      @if ($errors->has('top_type'))
                          <span class="help-block">
                              <strong>{{ $errors->first('top_type') }}</strong>
                          </span>
                      @endif
                  </div>
              </div>
	            <div class="form-group">
  			        <div class="col-sm-12">          
  			            <div id="example" style="overflow: scroll;"></div>
  			        </div>
  			      </div>
              <div class="form-grup">
                <div class="col-sm-12">
                  <button type="button" class="btn btn-warning" id="btn-recalculate">Recalculate</button>
                </div>
              </div>
              <div class="form-group">
                <label for="format_summary_total_gross" class="col-sm-2 control-label">Total Gross Rate</label>
                <div class="col-sm-4">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="format_summary_total_gross" id="format_summary_total_gross" placeholder="Total Gross Rate" required="true" maxlength="100" value="{{ old('format_summary_total_gross') }}">
                        <input type="hidden" name="summary_total_gross" id="summary_total_gross" value="{{ old('summary_total_gross') }}">
                    </div>
                    @if ($errors->has('summary_total_gross'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_gross') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="format_summary_total_internal_omzet" class="col-sm-2 control-label">Total Internal Omzet</label>
                <div class="col-sm-4">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="format_summary_total_internal_omzet" id="format_summary_total_internal_omzet" placeholder="Total Internal Omzet" required="true" maxlength="100" value="{{ old('format_summary_total_internal_omzet') }}">
                        <input type="hidden" name="summary_total_internal_omzet" id="summary_total_internal_omzet" value="{{ old('summary_total_internal_omzet') }}">
                    </div>
                    @if ($errors->has('summary_total_internal_omzet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_internal_omzet') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="format_summary_total_disc" class="col-sm-2 control-label">Total Discount</label>
                <div class="col-sm-4">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="format_summary_total_disc" id="format_summary_total_disc" placeholder="Total Discount" required="true" maxlength="100" value="{{ old('format_summary_total_disc') }}">
                        <input type="hidden" name="summary_total_discount" id="summary_total_discount" value="{{ old('summary_total_discount') }}">
                    </div>
                    @if ($errors->has('summary_total_discount'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_discount') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="format_summary_total_media_cost" class="col-sm-2 control-label">Total Media Cost</label>
                <div class="col-sm-4">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="format_summary_total_media_cost" id="format_summary_total_media_cost" placeholder="Total Media Cost" required="true" maxlength="100" value="{{ old('format_summary_total_media_cost') }}">
                        <input type="hidden" name="summary_total_media_cost" id="summary_total_media_cost" value="{{ old('summary_total_media_cost') }}">
                    </div>
                    @if ($errors->has('summary_total_media_cost'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_media_cost') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="format_summary_total_nett" class="col-sm-2 control-label">Total Nett Rate</label>
                <div class="col-sm-4">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="format_summary_total_nett" id="format_summary_total_nett" placeholder="Total Nett Rate" required="true" maxlength="100" value="{{ old('format_summary_total_nett') }}">
                        <input type="hidden" name="summary_total_nett" id="summary_total_nett" value="{{ old('summary_total_nett') }}">
                    </div>
                    @if ($errors->has('summary_total_nett'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_nett') }}</strong>
                        </span>
                    @endif
                </div>
                <label for="format_summary_total_cost_pro" class="col-sm-2 control-label">Total Cost Pro</label>
                <div class="col-sm-4">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="format_summary_total_cost_pro" id="format_summary_total_cost_pro" placeholder="Total Cost Pro" required="true" maxlength="100" value="{{ old('format_summary_total_cost_pro') }}">
                        <input type="hidden" name="summary_total_cost_pro" id="summary_total_cost_pro" value="{{ old('summary_total_cost_pro') }}">
                    </div>
                    @if ($errors->has('summary_total_cost_pro'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_cost_pro') }}</strong>
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
                      <span>
                        <strong>Max filesize: 10 MB. Allowed File(s): .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, .rar, .zip</strong>
                    </span>
                  </div>
              </div>
              <div class="form-group">
                <label for="summary_notes" class="col-sm-2 control-label">Notes</label>
                <div class="col-sm-10">
                  <div class="fg-line">
                    <textarea name="summary_notes" id="summary_notes" class="form-control input-sm" placeholder="Summary Notes">{{ old('summary_notes') }}</textarea>
                  </div>
                  @if ($errors->has('summary_notes'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_notes') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
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
              @include('vendor.material.workorder.summary.modal_preview')
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<!-- <button type="submit" class="btn btn-primary btn-sm">Submit</button> -->
                    <a id="btn-preview" data-toggle="modal" href="#modalPreview" class="btn btn-primary btn-sm waves-effect">Preview</a>
                    <a href="{{ url('workorder/summary') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('vendor/handsontable/handsontable.full.js') }}" rel="stylesheet"></script>  
<script src="{{ url('vendor/handsontable/numbro/languages.js') }}" rel="stylesheet"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/workorder/summary-create.js') }}"></script>

@include('vendor.material.workorder.summary.hot_validation')
@endsection

