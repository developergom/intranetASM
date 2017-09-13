@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Proposal<small>Approve Proposal & Select PIC</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="">
        		{{ csrf_field() }}
        		<div class="form-group">
        			<label for="proposal_type_id" class="col-sm-2 control-label">Type</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="proposal_type_id" id="proposal_type_id" class="selectpicker" data-live-search="true" required="true">
	        					<option value=""></option>
	        					@foreach($proposal_types as $row)
	        						{!! $selected = '' !!}
                                	@if($proposal->proposal_type_id==$row->proposal_type_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('proposal_type_id'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('proposal_type_id') }}</strong>
		                </span>
		            @endif
        		</div>
				<div class="form-group">
				    <label for="proposal_name" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" name="proposal_name" id="proposal_name" placeholder="Proposal Name" required="true" maxlength="200" value="{{ $proposal->proposal_name }}" readonly="true">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="industry_id" class="col-sm-2 control-label">Industry</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($proposal->industries as $row)
				            	<span class="badge">{{ $row->industry_name }}</span>
							@endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_deadline" class="col-sm-2 control-label">Deadline</label>
				    <div class="col-sm-3">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" name="proposal_deadline" id="proposal_deadline" placeholder="Deadline" required="true" maxlength="100" value="{{ $proposal->proposal_deadline }}" readonly="true">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_budget" class="col-sm-2 control-label">Budget</label>
				    <div class="col-sm-3">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm input-mask" name="proposal_budget" id="proposal_budget" placeholder="Budget" required="true" maxlength="17" value="{{ number_format($proposal->proposal_budget) }}" readonly="true">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="client_id" class="col-sm-2 control-label">Client</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <a href="{{ url('/master/client/' . $proposal->client->client_id) }}" target="_blank"><span class="badge">{{ $proposal->client->client_name }}</span></a>
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="client_contact_id" class="col-sm-2 control-label">Contact</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($proposal->client_contacts as $row)
				            	<a href="{{ url('/master/client/' . $proposal->client->client_id) }}" target="_blank"><span class="badge">{{ $row->client_contact_name . ' | ' . $row->client_contact_phone }}</span></a><br/>
							@endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="brand_id" class="col-sm-2 control-label">Brand</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <span class="badge">{{ $proposal->brand->brand_name }}</span>
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="media_id" class="col-sm-2 control-label">Media</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($proposal->medias as $row)
				            	<a href="{{ url('/master/media/' . $row->media_id) }}" target="_blank"><span class="badge">{{ $row->media_name }}</span></a>
							@endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="inventory_planner_name" class="col-sm-2 control-label">Inventory Planner Linked</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				        @foreach($proposal->inventoriesplanner as $inventoryplanner)
				            <a href="{{ url('inventory/inventoryplanner/' . $inventoryplanner->inventory_planner_id) }}" target="_blank" title="Click to View"><span class="badge">{{ $inventoryplanner->inventory_planner_title . ' created by ' . $inventoryplanner->created_by->user_firstname . ' ' . $inventoryplanner->created_by->user_lastname }}</span></a><br/>
				        @endforeach
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_background" class="col-sm-2 control-label">Background</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            {!! $proposal->proposal_background !!}
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_objective" class="col-sm-2 control-label">Objective</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            {!! $proposal->proposal_objective !!}
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_target_audience" class="col-sm-2 control-label">Target Audience</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            {!! $proposal->proposal_target_audience !!}
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_mandatory" class="col-sm-2 control-label">Mandatory</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            {!! $proposal->proposal_mandatory !!}
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_campaign_product" class="col-sm-2 control-label">Campaign/Product</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            {!! $proposal->proposal_campaign_product !!}
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            @foreach ($proposal->uploadfiles as $uploadedfile)
				                @if($uploadedfile->upload_file_revision==$proposal->revision_no)
				                	<div class="col-sm-6 col-md-3">
				                		<div class="thumbnail">
				                			@if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
				                			<img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
				                			@else
				                			<img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
				                			@endif
				                			<div class="caption">
				                				<h4>{{ $uploadedfile->upload_file_name }}</h4>
				                				<p>{{ $uploadedfile->upload_file_desc }}</p>
				                				<div class="m-b-5">
				                					@can('Proposal-Download')
				                					<a class="btn btn-sm btn-primary waves-effect" href="{{ url('download/file/' . $uploadedfile->upload_file_id) }}" role="button">Download File</a>
				                					@endcan
				                				</div>
				                			</div>
				                		</div>
				                	</div>
				                @endif
				        	@endforeach
				        </div>
				    </div>
				</div>
				<hr/>
				<div class="form-group">
					<label for="revision_no" class="col-sm-2 control-label">Revision</label>
					<div class="col-sm-10">
						<div class="fg-line">
							<input type="text" class="form-control input-sm" id="revision_no" readonly="true" value="{{ $proposal->revision_no }}">
						</div>
					</div>
				</div>
				<div class="form-group">
				    <label for="current_user" class="col-sm-2 control-label">Current User</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" placeholder=Current User" readonly="true" maxlength="100" value="{{ $proposal->_currentuser->user_firstname . ' ' . $proposal->_currentuser->user_lastname }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="pic" class="col-sm-2 control-label">PIC</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" placeholder=PIC" readonly="true" maxlength="100" value="{{ ($proposal->pic!=null) ? ($proposal->_pic->user_firstname . ' ' . $proposal->_pic->user_lastname) : '-' }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_no" class="col-sm-2 control-label">Proposal No</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="proposal_no" readonly="true" value="{{ $proposal->proposal_no }}">
				        </div>
				    </div>
				</div>
				@if($proposal->flow_no==98)
				<div class="form-group">
				    <label for="proposal_method" class="col-sm-2 control-label">Method</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="proposal_method" readonly="true" value="{{ $proposal->proposalmethod->proposal_method_name }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="proposal_status" class="col-sm-2 control-label">Proposal Status</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="proposal_status" readonly="true" value="{{ $proposal->proposalstatus->proposal_status_name }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="ready_date" class="col-sm-2 control-label">Ready Date</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" id="ready_date" readonly="true" value="{{ $proposal->proposal_ready_date }}">
				        </div>
				    </div>
				</div>
				@endif
				<div class="form-group">
				    <label for="created_by" class="col-sm-2 control-label">Created By</label>
				    <div class="col-sm-10">
				        <div class="fg-line">
				            <input type="text" class="form-control input-sm" placeholder="Created By" readonly="true" maxlength="100" value="{{ $proposal->created_by->user_firstname . ' ' . $proposal->created_by->user_lastname }}">
				        </div>
				    </div>
				</div>
				<div class="form-group">
				    <label for="history" class="col-sm-2 control-label">History</label>
				    <div class="col-sm-10">
				    	<button class="btn btn-primary waves-effect collapsed" type="button" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">Show/Hide History</button>
				        <div class="timeline collapse" id="collapseHistory">
				        @foreach($proposal->proposalhistories as $key => $value)
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
										{!! $value->proposal_history_text !!}
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
        			<label for="pic" class="col-sm-2 control-label">PIC</label>
        			<div class="col-sm-10">
        				<div class="fg-line">
	        				<select name="pic" id="pic" class="selectpicker" data-live-search="true" required="true">	        				
	        					@foreach($pic as $row)
	        						{!! $selected = '' !!}
                                	@if(old('pic')==$row->user_id)
	                                	{!! $selected = 'selected' !!}
                                	@endif
	        						<option value="{{ $row->user_id }}" {{ $selected }}>{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
	        					@endforeach
	        				</select>
	        			</div>
        			</div>
        			@if ($errors->has('pic'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('pic') }}</strong>
		                </span>
		            @endif
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
<script src="{{ url('js/workorder/proposal-approvepic.js') }}"></script>
@endsection