<div class="form-group">
	<label for="proposal_type_id" class="col-sm-2 control-label">Type</label>
	<div class="col-sm-10">
		<div class="fg-line">
			<input type="text" name="proposal_type_id" id="proposal_type_id" class="form-control input-sm" value="{{ $proposal->proposaltype->proposal_type_name }}" readonly="true">
		</div>
	</div>
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
@if($proposal->proposal_total_offering==0)
<hr/>

<div class="form-group">
    <label class="col-sm-2 control-label">Offering Cost</label>
    <div class="col-sm-10">
        <div class="fg-line">        
            <div class="table-responsive">
                <table id="grid-data-onprocess" class="table table-hover">
                    <thead>
                        <tr>
                            <th data-column-id="cost" data-order="asc"><span class="badge">Cost</span></th>
                            <th data-column-id="media_cost_print" data-order="asc"><span class="badge">Media Cost Print</span></th>
                            <th data-column-id="media_cost_other" data-order="asc"><span class="badge">Media Cost Other</span></th>
                            <th data-column-id="total_offering" data-order="asc"><span class="badge">Total Offering</span></th>
                            <th data-column-id="" data-formatter="" data-sortable=""><span class="badge">Status</span></th>
                        </tr>        
                    </thead>
                    <tbody>
                        <?php 
                        $rowcount = count($proposal->costdetails_proposal);
                        ?>
                        @if($rowcount == 0)
                            <tr>
                                <th colspan="5"><center><label style="font-size: 14px;">Cost Not Set</label></center></th>
                            </tr>
                        @else
                            <?php
                            for($i=0; $i<$rowcount; $i++)
                            {
                            //echo $inventoryplanner->costdetails[$i]->inventory_planner_cost; 
                            ?>
                            <tr>
                                @if($proposal->costdetails_proposal[$i]->status == "1")
                                    <th><span class="badge bgm-green" id="cost_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_cost) }}</span></th>
                                    <th><span class="badge bgm-green" id="media_cost_print_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_media_cost_print) }}</span></th>
                                    <th><span class="badge bgm-green" id="media_cost_other_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_media_cost_other) }}</span></th>
                                    <th><span class="badge bgm-green" id="total_offering_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_total_offering) }}</span></th>
                                    <th><label class="badge bgm-green">SELECTED</label></th>
                                @else
                                    <th><span id="cost_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_cost) }}</span></th>
                                    <th><span id="media_cost_print_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_media_cost_print) }}</span></th>
                                    <th><span id="media_cost_other_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_media_cost_other) }}</span></th>
                                    <th><span id="total_offering_choose">{{ number_format($proposal->costdetails_proposal[$i]->proposal_total_offering) }}</span></th>
                                    <th><label class="badge bgm-gray">UNSELECTED</label></th>
                                @endif
                            </tr>   
                            <?php } ?>
                        @endif
                    </tbody>
                </table>
            </div>  
        </div>
    </div>
</div>
@endif
<!--
@if($proposal->proposal_total_deal!=0)
<hr/>
<div class="form-group">
    <label for="proposal_deal_cost" class="col-sm-2 control-label">Deal Cost</label>
    <div class="col-sm-2">
        <span class="badge bgm-green">{{ number_format($proposal->proposal_deal_cost) }}</span>
    </div>
    <label for="proposal_deal_media_cost_print" class="col-sm-2 control-label">Deal Media Cost Print</label>
    <div class="col-sm-2">
        <span class="badge bgm-green">{{ number_format($proposal->proposal_deal_media_cost_print) }}</span>
    </div>
    <label for="proposal_deal_media_cost_other" class="col-sm-2 control-label">Deal Media Cost Other</label>
    <div class="col-sm-2">
        <span class="badge bgm-green">{{ number_format($proposal->proposal_deal_media_cost_other) }}</span>
    </div>
</div>
<div class="form-group">
    <label for="proposal_total_deal" class="col-sm-2 control-label">Total Deal</label>
    <div class="col-sm-2">
        <span class="badge bgm-green">{{ number_format($proposal->proposal_total_deal) }}</span>
    </div>
</div>
@endif
-->
<hr/>
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
                				<h6>{{ $uploadedfile->upload_file_name }}</h6>
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