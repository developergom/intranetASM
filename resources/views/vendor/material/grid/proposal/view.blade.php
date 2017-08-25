<div class="form-group">
    <label for="grid_proposal_name" class="col-sm-2 control-label">Name</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="grid_proposal_name" id="grid_proposal_name" placeholder="Project Task Name" required="true" maxlength="100" value="{{ $proposal->grid_proposal_name }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="grid_proposal_deadline" class="col-sm-2 control-label">Deadline</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="grid_proposal_deadline" id="grid_proposal_deadline" placeholder="Deadline" required="true" maxlength="10" value="{{ $deadline }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="grid_proposal_desc" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <div class="fg-line">
            {!! $proposal->grid_proposal_desc !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label for="current_user" class="col-sm-2 control-label">Current User</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="current_user" id="current_user" placeholder="Current User" required="true" maxlength="100" value="{{ $proposal->_currentuser->user_firstname }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="approval_1" class="col-sm-2 control-label">Lead Generation PIC</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="approval_1" id="approval_1" placeholder="Lead Generation PIC" required="true" maxlength="100" value="{{ ($proposal->approval_1 == 0) ? '-' : $proposal->_approval_1->user_firstname }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="puc" class="col-sm-2 control-label">PIC 1</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="pic1" id="pic1" placeholder="PIC 1" required="true" maxlength="100" value="{{ ($proposal->pic_1 == 0) ? '-' : $proposal->_pic_1->user_firstname }}" readonly="true">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="puc" class="col-sm-2 control-label">PIC 2</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="pic2" id="pic2" placeholder="PIC 2" required="true" maxlength="100" value="{{ ($proposal->pic_2 == 0) ? '-' : $proposal->_pic_2->user_firstname }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($proposal->uploadfiles as $uploadedfile)
        	<div class="col-sm-6 col-md-3">
        		<div class="thumbnail">
        			@if($uploadedfile->upload_file_type=='jpg' || $uploadedfile->upload_file_type=='png' || $uploadedfile->upload_file_type=='gif' || $uploadedfile->upload_file_type=='jpeg')
        			<img src="{{ url($uploadedfile->upload_file_path . '/' . $uploadedfile->upload_file_name) }}" alt="{{ $uploadedfile->upload_file_name }}">
        			@else
        			<img src="{{ url('img/filetypes/' . $uploadedfile->upload_file_type . '.png') }}" alt="">
        			@endif
        			<div class="caption">
        				<h4>{{ $uploadedfile->upload_file_name . ' Revision (' . $uploadedfile->upload_file_revision . ') ' }}</h4>
        				<p>{{ $uploadedfile->upload_file_desc }}</p>
        				<div class="m-b-5">
        					@can('Grid Proposal-Download')
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