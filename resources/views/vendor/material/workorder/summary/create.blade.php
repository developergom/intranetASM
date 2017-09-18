@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('vendor/handsontable/handsontable.full.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Summary<small>Create Summary Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('workorder/summary') }}">
        		{{ csrf_field() }}
            <input type="hidden" name="proposal_id" value="{{ $proposal->proposal_id }}">
        		@include('vendor.material.workorder.proposal.view')
	            <div class="form-group">
  			        <div class="col-sm-12">          
  			            <div id="example"></div>
  			        </div>
  			      </div>
              <div class="form-group">
                <label for="summary_total_gross" class="col-sm-2 control-label">Total Gross Rate</label>
                <div class="col-sm-10">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="summary_total_gross" id="summary_total_gross" placeholder="Total Gross Rate" required="true" maxlength="100" value="{{ old('summary_total_gross') }}">
                    </div>
                    @if ($errors->has('summary_total_gross'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_gross') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="summary_total_disc" class="col-sm-2 control-label">Total Discount</label>
                <div class="col-sm-10">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="summary_total_disc" id="summary_total_disc" placeholder="Total Discount" required="true" maxlength="100" value="{{ old('summary_total_discount') }}">
                    </div>
                    @if ($errors->has('summary_total_discount'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_discount') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="summary_total_nett" class="col-sm-2 control-label">Total Nett Rate</label>
                <div class="col-sm-10">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="summary_total_nett" id="summary_total_nett" placeholder="Total Nett Rate" required="true" maxlength="100" value="{{ old('summary_total_nett') }}">
                    </div>
                    @if ($errors->has('summary_total_nett'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_nett') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                <label for="summary_total_internal_omzet" class="col-sm-2 control-label">Total Internal Omzet</label>
                <div class="col-sm-10">
                    <div class="fg-line">
                        <input type="text" class="form-control input-sm" name="summary_total_internal_omzet" id="summary_total_internal_omzet" placeholder="Total Internal Omzet" required="true" maxlength="100" value="{{ old('summary_total_internal_omzet') }}">
                    </div>
                    @if ($errors->has('summary_total_internal_omzet'))
                        <span class="help-block">
                            <strong>{{ $errors->first('summary_total_internal_omzet') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="form-group">
                  <label for="top_type" class="col-sm-2 control-label">Term of Payment</label>
                  <div class="col-sm-10">
                      <div class="fg-line">
                        <div class="radio m-b-15">
                          <label>
                              <input type="radio" name="top_type" value="bulk" {{ (old('top_type')=='bulk') ? 'checked' : '' }}>
                              <i class="input-helper"></i>
                              Bulk
                            </label>
                        </div>
                        <div class="radio m-b-15">
                          <label>
                              <input type="radio" name="top_type" value="termin" {{ (old('top_type')=='termin') ? 'checked' : '' }}>
                              <i class="input-helper"></i>
                              Termin
                            </label>
                        </div>
                        <div class="radio m-b-15">
                          <label>
                              <input type="radio" name="top_type" value="insertion" {{ (old('top_type')=='insertion') ? 'checked' : '' }}>
                              <i class="input-helper"></i>
                              Insertion
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
                <label for="summary_notes" class="col-sm-2 control-label">Notes</label>
                <div class="col-sm-10">
                  <div class="fg-line">
                    <textarea name="summary_notes" id="summary_notes" class="form-control input-sm" placeholder="Summary Notes"></textarea>
                  </div>
                </div>
              </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Submit</button>
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
@endsection

@section('customjs')
<script src="{{ url('js/workorder/summary-create.js') }}"></script>
@endsection