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
    <div class="col-sm-10">
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
            <span class="badge">{{ $proposal->client->client_name }}</span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="client_contact_id" class="col-sm-2 control-label">Contact</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($proposal->client_contacts as $row)
            	<span class="badge">{{ $row->client_contact_name . ' | ' . $row->client_contact_phone }}</span><br/>
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
            	<span class="badge">{{ $row->media_name }}</span>
			@endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="proposal_desc" class="col-sm-2 control-label">Creative Brief</label>
    <div class="col-sm-10">
        <div class="fg-line">
            {!! $proposal->proposal_desc !!}
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
        <div class="timeline">
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