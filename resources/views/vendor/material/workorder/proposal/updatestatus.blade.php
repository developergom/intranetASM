@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Proposal<small>Update Status Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		@include('vendor.material.workorder.proposal.view')
	            <div class="form-group">
	            	<label for="status" class="col-sm-2 control-label">Status</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<select name="status" id="status" class="selectpicker" data-live-search="true" required="true">
	            				<option value=""></option>
	        					<option value="1">Sold</option>
	        					<option value="2">Not Sold</option>
	        					<option value="3">Revision</option>
	        				</select>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_deal_cost" class="col-sm-2 control-label">Deal Cost</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_deal_cost" id="proposal_deal_cost" placeholder="Deal Cost" maxlength="20" value="{{ old('proposal_deal_cost') }}" required="true">
	                    </div>
	                    @if ($errors->has('proposal_deal_cost'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_deal_cost') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_deal_cost">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_deal_media_cost_print" class="col-sm-2 control-label">Deal Media Cost Print</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_deal_media_cost_print" id="proposal_deal_media_cost_print" placeholder="Deal Media Cost Print" maxlength="20" value="{{ old('proposal_deal_media_cost_print') }}" required="true">
	                    </div>
	                    @if ($errors->has('proposal_deal_media_cost_print'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_deal_media_cost_print') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_deal_media_cost_print">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_deal_media_cost_other" class="col-sm-2 control-label">Deal Media Cost Digital/Other</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_deal_media_cost_other" id="proposal_deal_media_cost_other" placeholder="Deal Media Cost Other" maxlength="20" value="{{ old('proposal_deal_media_cost_other') }}" required="true">
	                    </div>
	                    @if ($errors->has('proposal_deal_media_cost_other'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_deal_media_cost_other') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_deal_media_cost_other">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_total_deal" class="col-sm-2 control-label">Total Deal</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_total_deal" id="proposal_total_deal" placeholder="Total Deal" maxlength="20" value="{{ old('proposal_total_deal') }}" required="true">
	                    </div>
	                    @if ($errors->has('proposal_total_deal'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_total_deal') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_total_deal">0</span>
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
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/workorder/proposal-updatestatus.js') }}"></script>
@endsection