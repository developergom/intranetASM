<div class="form-group">
	<label for="inventory_type_id" class="col-sm-2 control-label">Type</label>
	<div class="col-sm-10">
		<div class="fg-line">
			<input class="form-control input-sm" placeholder="Type" readonly="true" value="{{ $inventoryplanner->proposaltype->proposal_type_name }}">
		</div>
	</div>
</div>
<div class="form-group">
    <label for="inventory_category_id" class="col-sm-2 control-label">Category</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach($inventoryplanner->inventorycategories as $row)
                <span class="badge">{{ $row->inventory_category_name }}</span>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="inventory_source_id" class="col-sm-2 control-label">Source</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input class="form-control input-sm" placeholder="Source" readonly="true" value="{{ $inventoryplanner->inventorysource->inventory_source_name }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="inventory_planner_title" class="col-sm-2 control-label">Title</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input class="form-control input-sm" placeholder="Title" readonly="true" value="{{ $inventoryplanner->inventory_planner_title }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="implementation_id" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="right" title="Implementation of this inventory">Implementation</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach($inventoryplanner->implementations as $row)
            	<span class="badge">{{ $row->implementation_month_name . ' ' . $row->pivot->year }}</span>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="sell_period" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="right" title="Sell Period">Sell Period</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach($inventoryplanner->sellperiods as $row)
                <span class="badge">{{ $row->sell_period_month_name . ' ' . $row->pivot->year }}</span>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="media_id" class="col-sm-2 control-label">Media</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach($inventoryplanner->medias as $row)
            	<a href="{{ url('/master/media/' . $row->media_id) }}" target="_blank"><span class="badge">{{ $row->media_name }}</span></a>
            @endforeach
        </div>
    </div>
</div>
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
                            <!--<th data-column-id="" data-formatter="" data-sortable=""><span class="badge">Status</span></th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                         
                        $rowcount = count($inventoryplanner->costdetails);

                        for($i=0; $i<$rowcount; $i++)
                        {
                        //echo $inventoryplanner->costdetails[$i]->inventory_planner_cost; 
                        ?>
                        <tr>
                            @if($inventoryplanner->costdetails[$i]->status == "1")
                                <th><span class="label label-success" id="cost_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_cost) }}</span></th>
                                <th><span class="label label-success" id="media_cost_print_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_media_cost_print) }}</span></th>
                                <th><span class="label label-success" id="media_cost_other_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_media_cost_other) }}</span></th>
                                <th><span class="label label-success" id="total_offering_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_total_offering) }}</span></th>
                                <!-- <th><label class="label label-success">SELECTED</label></th> -->
                            @else
                                <th><span id="cost_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_cost) }}</span></th>
                                <th><span id="media_cost_print_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_media_cost_print) }}</span></th>
                                <th><span id="media_cost_other_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_media_cost_other) }}</span></th>
                                <th><span id="total_offering_choose">{{ number_format($inventoryplanner->costdetails[$i]->inventory_planner_total_offering) }}</span></th>
                                <!-- <th><label class="label label-default">SELECTED</label></th> -->
                            @endif
                        </tr>   
                        <?php } ?>
                    </tbody>
                </table>
            </div> 
                
        </div>
    </div>
</div>
<!-- 
<div class="form-group">
    <label for="action_plan_id" class="col-sm-2 control-label">Action Plan</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach($inventoryplanner->actionplans as $row)
            	<span class="badge">{{ $row->action_plan_title }}</span>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="event_plan_id" class="col-sm-2 control-label">Event Plan</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach($inventoryplanner->eventplans as $row)
            	<span class="badge">{{ $row->event_plan_name }}</span>
            @endforeach
        </div>
    </div>
</div> -->
<div class="form-group">
    <label for="inventory_planner_desc" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <div class="fg-line">
            {!! $inventoryplanner->inventory_planner_desc !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($inventoryplanner->uploadfiles as $uploadedfile)
                @if($uploadedfile->upload_file_revision==$inventoryplanner->revision_no)
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
                					@can('Inventory Planner-Download')
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
<div class="form-group">
    <label for="created_by" class="col-sm-2 control-label">Created By</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" placeholder="Created By" readonly="true" maxlength="100" value="{{ $inventoryplanner->created_by->user_firstname . ' ' . $inventoryplanner->created_by->user_lastname }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="history" class="col-sm-2 control-label">History</label>
    <div class="col-sm-10">
        <button class="btn btn-primary waves-effect collapsed" type="button" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">Show/Hide History</button>
        <div class="timeline collapse" id="collapseHistory">
        @foreach($inventoryplanner->inventoryplannerhistories as $key => $value)
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
						{!! $value->inventory_planner_history_text !!}
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