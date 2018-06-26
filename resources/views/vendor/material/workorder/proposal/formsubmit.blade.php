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
	                <label for="proposal_cost" class="col-sm-2 control-label">Cost</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_cost" id="proposal_cost" placeholder="Cost" maxlength="20" value="{{ old('proposal_cost') }}">
	                    </div>
	                    @if ($errors->has('proposal_cost'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_cost') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_cost">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_media_cost_print" class="col-sm-2 control-label">Media Cost Print</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_media_cost_print" id="proposal_media_cost_print" placeholder="Media Cost Print" maxlength="20" value="{{ old('proposal_media_cost_print') }}">
	                    </div>
	                    @if ($errors->has('proposal_media_cost_print'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_media_cost_print') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_media_cost_print">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_media_cost_other" class="col-sm-2 control-label">Media Cost Digital/Other</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_media_cost_other" id="proposal_media_cost_other" placeholder="Media Cost Other" maxlength="20" value="{{ old('proposal_media_cost_other') }}">
	                    </div>
	                    @if ($errors->has('proposal_media_cost_other'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_media_cost_other') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_media_cost_other">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="proposal_total_offering" class="col-sm-2 control-label">Total Offering</label>
	                <div class="col-sm-4">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="proposal_total_offering" id="proposal_total_offering" placeholder="Total Offering" maxlength="20" value="{{ old('proposal_total_offering') }}">
	                    </div>
	                    @if ($errors->has('proposal_total_offering'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('proposal_total_offering') }}</strong>
			                </span>
			            @endif
	                </div>
	                <div class="col-sm-6">
	                	<span class="badge" id="format_proposal_total_offering">0</span>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="" class="col-sm-2 control-label"></label>
	            	<div class="col-sm-4" align="right">
	            		<div class="fg-line">
	            			<a href="javascript:void(0)" class="btn btn-warning waves-effect" id="btn_add_offering">ADD OFFERING</a>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-offset-2 col-sm-10">
	            		<table id="offering_post" class="table">
	            			<thead>
	            				<tr>
	            					<th>Cost</th>
	            					<th>Media Cost Print</th>
	            					<th>Media Cost Digital/Other</th>
	            					<th>Total Offering</th>
	            				</tr>
	            			</thead>
	            			<tbody>
		            			@foreach($proposal->costdetails_proposal as $row)
		            			<tr>  	
		            				<input type="hidden" name="offering_cost_details_id[]" value="{{ $row->proposal_cost_details_id }}" readonly>
						    		<td><input type="text" name="offering_post_cost[]" class="form-control" value="{{ $row->proposal_cost }}" readonly></td>
						    		<td><input type="text" name="offering_post_media_cost_print[]" class="form-control" value="{{ $row->proposal_media_cost_print }}" readonly></td>
						    		<td><input type="text" name="offering_post_media_cost_other[]" class="form-control" value="{{ $row->proposal_media_cost_other }}" readonly></td>
						    		<td><input type="text" name="offering_post_total_offering[]" class="form-control" value="{{ $row->proposal_total_offering }}" readonly></td>
						    		<td><a href="javascript:void(0)" class="btn btn-danger btn-offering-delete">Remove</a></td>
						    	</tr>
		            			@endforeach
	            			</tbody>
	            		</table>
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