@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('vendor/handsontable/handsontable.full.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
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
        <div class="card-header"><h2>Summary<small>Approve Summary</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		<div class="form-group">
				    <label for="contract_no" class="col-sm-2 control-label">Contract No</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="contract_no" readonly="true" value="{{ $summary->contract->contract_no }}">
				        </div>
				    </div>
				</div>
        		<div class="form-group">
				    <label for="proposal_no" class="col-sm-2 control-label">Proposal No</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="hidden" id="summary_id" value="{{ $summary->summary_id }}">
				            <input type="text" class="form-control input-sm" id="proposal_no" readonly="true" value="{{ $summary->contract->proposal->proposal_no }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_name" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" name="proposal_name" id="proposal_name" placeholder="Proposal Name" required="true" maxlength="200" value="{{ $summary->contract->proposal->proposal_name }}" readonly="true">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="industry_id" class="col-sm-2 control-label">Industry</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($summary->contract->proposal->industries as $row)
				            	<span class="badge">{{ $row->industry_name }}</span>
							@endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="client_id" class="col-sm-2 control-label">Client</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <a href="{{ url('/master/client/' . $summary->contract->proposal->client->client_id) }}" target="_blank"><span class="badge">{{ $summary->contract->proposal->client->client_name }}</span></a>
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="client_contact_id" class="col-sm-2 control-label">Contact</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($summary->contract->proposal->client_contacts as $row)
				            	<a href="{{ url('/master/client/' . $summary->contract->proposal->client->client_id) }}" target="_blank"><span class="badge">{{ $row->client_contact_name . ' | ' . $row->client_contact_phone }}</span></a><br/>
							@endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="brand_id" class="col-sm-2 control-label">Brand</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <span class="badge">{{ $summary->contract->proposal->brand->brand_name }}</span>
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="media_id" class="col-sm-2 control-label">Media</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($summary->contract->proposal->medias as $row)
				            	<a href="{{ url('/master/media/' . $row->media_id) }}" target="_blank"><span class="badge">{{ $row->media_name }}</span></a>
							@endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="top_type" class="col-sm-2 control-label">Term of Payment</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="top_type" readonly="true" value="{{ $summary->top_type }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="summary_notes" class="col-sm-2 control-label">Summary Notes</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            {!! $summary->summary_notes !!}
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="summary_order_no" class="col-sm-2 control-label">Order No</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="summary_order_no" readonly="true" value="{{ $summary->summary_order_no }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($summary->uploadfiles as $uploadedfile)
			                    <div class="col-sm-6 col-md-3">
			                        <div class="thumbnail">
			                            @if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
			                            <img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
			                            @else
			                            <img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
			                            @endif
			                            <div class="caption">
			                                <h6>{{ $uploadedfile->upload_file_name . ' - [Rev ' . $uploadedfile->upload_file_revision . ']' }}</h6>
			                                <p>{{ $uploadedfile->upload_file_desc }}</p>
			                                <div class="m-b-5">
			                                    @can('Summary-Download')
			                                    <a class="btn btn-sm btn-primary waves-effect" href="{{ url('download/file/' . $uploadedfile->upload_file_id) }}" role="button">Download File</a>
			                                    @endcan
			                                </div>
			                            </div>
			                        </div>
			                    </div>
				            @endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="created_by" class="col-sm-2 control-label">Created By</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" placeholder="Created By" readonly="true" maxlength="100" value="{{ $summary->created_by->user_firstname . ' ' . $summary->created_by->user_lastname }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="revision_no" class="col-sm-2 control-label">Revision</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <select name="revision_no" id="revision_no" class="selectpicker" data-live-search="true" required="true">
				                @for($i = 0;$i <= $summary->revision_no;$i++)
				                    {!! $selected = '' !!}
				                    @if($i==$summary->revision_no)
				                        {!! $selected = 'selected' !!}
				                    @endif
				                    <option value="{{ $i }}" {{ $selected }}>{{ $i }}</option> 
				                @endfor
				            </select>
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="current_user" class="col-sm-2 control-label">Current User</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" placeholder=Current User" readonly="true" maxlength="100" value="{{ $summary->_currentuser->user_firstname . ' ' . $summary->_currentuser->user_lastname }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="pic" class="col-sm-2 control-label">PIC</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" placeholder=PIC" readonly="true" maxlength="100" value="{{ ($summary->pic!=null) ? ($summary->_pic->user_firstname . ' ' . $summary->_pic->user_lastname) : '-' }}">
				        </div>
				    </div>
				</div>
				<hr/>
				<div class="form-group">
					<div class="col-sm-4 m-b-20">
                        <div class="toggle-switch toggle-switch-demo">
                            <label for="edit-items" class="ts-label">Edit Items?</label>
                            <input name="edit-items" id="edit-items" type="checkbox" hidden="hidden">
                            <label for="edit-items" class="ts-helper"></label>
                        </div>
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
	                        <input type="hidden" name="summary_total_gross" id="summary_total_gross" value="{{ $summary->summary_total_gross }}">
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
	                        <input type="hidden" name="summary_total_internal_omzet" id="summary_total_internal_omzet" value="{{ $summary->summary_total_internal_omzet }}">
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
	                        <input type="hidden" name="summary_total_discount" id="summary_total_discount" value="{{ $summary->summary_total_discount }}">
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
	                        <input type="hidden" name="summary_total_media_cost" id="summary_total_media_cost" value="{{ $summary->summary_total_media_cost }}">
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
	                        <input type="hidden" name="summary_total_nett" id="summary_total_nett" value="{{ $summary->summary_total_nett }}">
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
	                        <input type="hidden" name="summary_total_cost_pro" id="summary_total_cost_pro" value="{{ $summary->summary_total_cost_pro }}">
	                    </div>
	                    @if ($errors->has('summary_total_cost_pro'))
	                        <span class="help-block">
	                            <strong>{{ $errors->first('summary_total_cost_pro') }}</strong>
	                        </span>
	                    @endif
	                </div>
	              </div>
				<div class="form-group">
				    <label for="history" class="col-sm-2 control-label">History</label>
				    <div class="col-sm-10">
				    	<button class="btn btn-primary waves-effect collapsed" type="button" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">Show/Hide History</button>
				        <div class="timeline collapse" id="collapseHistory">
				        @foreach($summary->summaryhistories as $key => $value)
				        	<div class="t-view" data-tv-type="text">
				                <div class="tv-header media">
				                    <a href="#" class="tvh-user pull-left">
				                        <img class="img-responsive" src="{{ url('img/avatar/' . $value->created_by->user_avatar) }}" alt="$value->created_by->user_avatar">
				                    </a>
				                    <div class="media-body p-t-5">
				                        <strong class="d-block">{{ $value->created_by->user_firstname . ' ' . $value->created_by->user_lastname }}</strong>
				                        <small class="c-gray">{{ $value->created_at }}</small>
				                    </div>
				                </div>
				                <div class="tv-body">
									<p>
										{!! $value->summary_history_text !!}
									</p>
									<div class="clearfix"></div>
									<ul class="tvb-stats">
										<li class="tvbs-likes">{{ $value->approvaltype->approval_type_name }}</li>
									</ul>                          
				                </div>
				            </div>
				        @endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="export" class="col-sm-2 control-label">Export</label>
				    <div class="col-sm-10">
				        @can('Summary-Download')
				            <a href="{{ url('workorder/summary/api/exportXls/' . $summary->summary_id) }}" target="_blank"><button class="btn btn-success waves-effect collapsed" type="button">Export to .xlsx</button></a>
				        @endcan
				    </div>
				</div>
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
	            <div class="form-group">
	                <label for="messages" class="col-sm-2 control-label">Message</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="messages" id="messages" class="form-control input-sm" placeholder="MESSAGE">{{ old('messages') }}</textarea>
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
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/workorder/summary-approve.js') }}"></script>

@include('vendor.material.workorder.summary.hot_validation')
@endsection