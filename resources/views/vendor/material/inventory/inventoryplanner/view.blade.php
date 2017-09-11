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
            	<span class="badge">{{ $row->implementation_month_name }}</span>
            @endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="inventory_planner_year" class="col-sm-2 control-label">Year</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input class="form-control input-sm" placeholder="Year" readonly="true" value="{{ $inventoryplanner->inventory_planner_year }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="inventory_planner_deadline" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="right" title="This deadline is deadline which the inventory can be sold">Deadline</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input class="form-control input-sm" placeholder="Deadline" readonly="true" value="{{ Carbon\Carbon::createFromFormat('Y-m-d', $inventoryplanner->inventory_planner_deadline)->format('d/m/Y') }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="inventory_planner_participants" class="col-sm-2 control-label">Participants</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input class="form-control input-sm" placeholder="Participants" readonly="true" value="{{ $inventoryplanner->inventory_planner_participants }}">
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
</div><!-- 
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
                				<h4>{{ $uploadedfile->upload_file_name }}</h4>
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