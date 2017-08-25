<div class="form-group">
	<label for="project_task_type_id" class="col-sm-2 control-label">Task Type</label>
	<div class="col-sm-10">
		<div class="fg-line">
			<input type="text" class="form-control" readonly="true" value="{{ $projecttask->projecttasktype->project_task_type_name }}">
		</div>
	</div>
</div>
<div class="form-group">
    <label for="project_task_name" class="col-sm-2 control-label">Task Name</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="project_task_name" id="project_task_name" placeholder="Project Task Name" required="true" maxlength="100" value="{{ $projecttask->project_task_name }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_task_deadline" class="col-sm-2 control-label">Task Deadline</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="project_task_deadline" id="project_task_deadline" placeholder="Deadline" required="true" maxlength="10" value="{{ $deadline }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_task_desc" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <div class="fg-line">
            {!! old('project_task_desc') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_id" class="col-sm-2 control-label">Project Name</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <a href="{{ url('/grid/project/' . $projecttask->project_id) }}" target="_blank">{{ $projecttask->project->project_name . ' - ' . $projecttask->project->client->client_name }}</a>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="current_user" class="col-sm-2 control-label">Current User</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="current_user" id="current_user" placeholder="Current User" required="true" maxlength="100" value="{{ $projecttask->_currentuser->user_firstname }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="puc" class="col-sm-2 control-label">PIC</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <input type="text" class="form-control input-sm" name="pic" id="pic" placeholder="PIC" required="true" maxlength="100" value="{{ ($projecttask->pic == 0) ? '-' : $projecttask->_pic->user_firstname }}" readonly="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($projecttask->uploadfiles as $uploadedfile)
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
        					@can('Project Task-Download')
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