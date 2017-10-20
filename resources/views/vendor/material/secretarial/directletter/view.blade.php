<div class="form-group">
	<label for="letter_type_id" class="col-sm-2 control-label">Type</label>
	<div class="col-sm-10">
		<div class="fg-line">
			<input type="text" name="letter_type_id" id="letter_type_id" class="form-control input-sm" placeholder="Letter Type" value="{{ $letter->lettertype->letter_type_name }}" readonly="true">
		</div>
	</div>
</div>
<div class="form-group">
    <label for="letter_to" class="col-sm-2 control-label">Send To</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="letter_to" id="letter_to" placeholder="Send To" required="true" maxlength="100" value="{{ $letter->letter_to }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="contract_id" class="col-sm-2 control-label">Contract</label>
    <div class="col-sm-10">
        <div class="fg-line">
        	@foreach($letter->contracts as $contract)
        		<a href="{{ url('workorder/contract/' . $contract->contract_id) }}" target="_blank">
        			<span class="badge">{{ $contract->contract_no . ' - ' . $contract->proposal->proposal_name }}</span>
        		</a><br/>
        	@endforeach
        </div>
    </div>
</div>
<div class="form-group">
    <label for="letter_notes" class="col-sm-2 control-label">Notes</label>
    <div class="col-sm-10">
        <div class="fg-line">
        	{!! $letter->letter_notes !!}
        </div>
    </div>
</div>
<hr/>
<div class="form-group">
    <label for="letter_no" class="col-sm-2 control-label">Letter No</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" id="letter_no" readonly="true" value="{{ ($letter->letter_no=='') ? '-' : $letter->letter_no }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="revision_no" class="col-sm-2 control-label">Revision</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" id="revision_no" readonly="true" value="{{ $letter->revision_no }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="created_by" class="col-sm-2 control-label">Created By</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" placeholder="Created By" readonly="true" maxlength="100" value="{{ $letter->created_by->user_firstname . ' ' . $letter->created_by->user_lastname }}">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="upload_file" class="col-sm-2 control-label">Uploaded File(s)</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($letter->uploadfiles as $uploadedfile)
                @if($uploadedfile->upload_file_revision==$letter->revision_no)
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
                                    @can('Direct Letter-Download')
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
    <label for="history" class="col-sm-2 control-label">History</label>
    <div class="col-sm-10">
    	<button class="btn btn-primary waves-effect collapsed" type="button" data-toggle="collapse" data-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">Show/Hide History</button>
        <div class="timeline collapse" id="collapseHistory">
        @foreach($letter->letterhistories as $key => $value)
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
						{!! $value->letter_history_text !!}
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