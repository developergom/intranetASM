<div class="form-group">
    <label for="project_code" class="col-sm-2 control-label">Project Code</label>
    <div class="col-sm-10">
        <div class="fg-line">
			<input type="text" class="form-control" name="project_code" id="project_code" placeholder="Project Code" maxlength="20" value="{{ $project->project_code }}" disabled="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_name" class="col-sm-2 control-label">Project Name</label>
    <div class="col-sm-10">
        <div class="fg-line">
			<input type="text" class="form-control" name="project_name" id="project_name" placeholder="Project Name" required="true" maxlength="100" value="{{ $project->project_name }}" disabled="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_periode_start" class="col-sm-2 control-label">Project Start</label>
    <div class="col-sm-10">
        <div class="fg-line">
			<input type="text" class="form-control" name="project_periode_start" id="project_periode_start" placeholder="Project Start e.g 17/08/1945" required="true" maxlength="100" value="{{ $project_start }}" disabled="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_periode_end" class="col-sm-2 control-label">Project End</label>
    <div class="col-sm-10">
        <div class="fg-line">
			<input type="text" class="form-control" name="project_periode_end" id="project_periode_end" placeholder="Project End e.g 17/08/1945" required="true" maxlength="100" value="{{ $project_end }}" disabled="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="client" class="col-sm-2 control-label">Client</label>
    <div class="col-sm-10">
        <div class="fg-line">
           	<input class="form-control" value="{{ $project->client->client_name }}" placeholder="Client" disabled="true">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="project_desc" class="col-sm-2 control-label">Description</label>
    <div class="col-sm-10">
        <div class="fg-line">
            <textarea name="project_desc" id="project_desc" class="form-control input-sm" placeholder="Description" disabled="true">{{ $project->project_desc }}</textarea>
        </div>
    </div>
</div>
<div class="form-group">
	<label for="project_tasks" class="col-sm-2 control-label">Tasks</label>
	<div class="col-sm-10">
		@foreach($project->projecttasks as $row)
			<a href="{{ url('/grid/projecttask/' . $row->project_task_id) }}" target="_blank"><span class="badge">{{ $row->project_task_name . ' | PIC : ' }} {!! ($row->pic!='0') ? $row->_pic->user_firstname : '-' !!}</span> {!! ($row->flow_no == 98) ? '<i class="zmdi zmdi-check zmdi-hc-fw" title="Finished"></i>' : '<i class="zmdi zmdi-refresh zmdi-hc-fw" title="On Process"></i>' !!}</a><br/>
		@endforeach
	</div>
</div>
<div class="form-group">
    <label for="upload_file" class="col-sm-2 control-label">Upload File(s)</label>
    <div class="col-sm-10">
        <div class="fg-line">
            @foreach ($project->uploadfiles as $uploadedfile)
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
                            @can('Project-Download')
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