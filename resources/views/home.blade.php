@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/announcement-home.css') }}" rel="stylesheet">
<link href="{{ url('css/monthly.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(count($announcements) > 0)
    <div id="announcement-container" class="alert alert-info" role="alert">
        <div id="text">
            <!-- 1 Lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;
            2 Lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;
            3 Lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum lorem itsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp; -->
            @foreach($announcements as $announcement)
                {!! $announcement->announcement_detail . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;' !!}
            @endforeach
        </div>
    </div>
    @endif
	<div class="block-header">
        <h2>Dashboard</h2>
        
        <ul class="actions">
            <li>
                <a href="#">
                    <i class="zmdi zmdi-trending-up"></i>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="zmdi zmdi-check-all"></i>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" data-toggle="dropdown">
                    <i class="zmdi zmdi-more-vert"></i>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="#">Refresh</a>
                    </li>
                    <li>
                        <a href="#">Manage Widgets</a>
                    </li>
                    <li>
                        <a href="#">Widgets Settings</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- <div class="card">
        <div class="card-header">Dashboard</div>
        <div class="card-body card-padding">
            You are logged in!
        </div>
    </div> -->
    @can('Action Plan-Read')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header"><h4>Plan Calendar</h4></div>
                <div class="card-body card-padding">
                    <div class="monthly" id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header"><h4>Upcoming Plan</h4></div>
                <div class="card-body card-padding">
                    <div role="tabpanel" class="tab">
                        <ul class="tab-nav" role="tablist">
                            <li class="active"><a href="#below30" aria-controls="below30" role="tab" data-toggle="tab" aria-expanded="true">< 30 days</a></li>
                            <li role="presentation" class=""><a href="#upper30" aria-controls="upper30" role="tab" data-toggle="tab" aria-expanded="false">> 30 days</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane animated flipInX active" id="below30">
                                <div class="listview" id="list-below30"></div>
                            </div>
                            <div role="tabpanel" class="tab-pane animated flipInX" id="upper30">
                                <div class="listview" id="list-upper30"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @can('Project Task-Read')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header"><h4>Project Task</h4></div>
                <div class="card-body card-padding">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="project-task-select-pic" class="col-sm-2 control-label">PIC</label>
                            <div class="col-sm-8">
                                <div class="fg-line">
                                    <select name="project-task-select-pic[]" id="project-task-select-pic" class="selectpicker" data-live-search="true" multiple>
                                        <option value="{{ $project_task_current->user_id }}" selected>{{ $project_task_current->user_firstname . ' ' . $project_task_current->user_lastname }}</option>
                                        @foreach($project_task_subordinate as $row)
                                            <option value="{{ $row->user_id }}">{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary waves-effect" id="btn-project-task-process">Process</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="project-task-select-author" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-8">
                                <div class="fg-line">
                                    <select name="project-task-select-author[]" id="project-task-select-author" class="selectpicker" data-live-search="true" multiple>
                                        <option value="{{ $project_task_current->user_id }}" selected>{{ $project_task_current->user_firstname . ' ' . $project_task_current->user_lastname }}</option>
                                        @foreach($project_task_subordinate as $row)
                                            <option value="{{ $row->user_id }}">{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="project-task-select-types" class="col-sm-2 control-label">Type</label>
                            <div class="col-sm-8">
                                <div class="fg-line">
                                    <select name="project-task-select-types[]" id="project-task-select-types" class="selectpicker" data-live-search="true" multiple>
                                        @foreach($project_task_types as $row)
                                            <option value="{{ $row->project_task_type_id }}">{{ $row->project_task_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="project-task-select-projects" class="col-sm-2 control-label">Project</label>
                            <div class="col-sm-8">
                                <div class="fg-line">
                                    <select name="project-task-select-projects[]" id="project-task-select-projects" class="selectpicker" data-live-search="true" multiple>
                                        @foreach($projects as $row)
                                            <option value="{{ $row->project_id }}">{{ $row->project_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                    </form>
                    <div class="monthly" id="project-task-calendar"></div>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jquery.marquee.min.js') }}"></script>
<script src="{{ url('js/monthly.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript">
$(document).ready(function(){
    $('#text').marquee({
        duration: 60000,
        startVisible: true,
        duplicated: true
      });

    @can('Action Plan-Read')
    $('#calendar').monthly({
        'mode' : 'event',
        'stylePast' : true,
        'dataType' : 'json',
        'jsonUrl' : base_url + 'api/loadPlan',
    });

    $.ajax({
        url: base_url + 'api/loadUpcomingPlan/below/-30',
        type: 'GET',
        dataType: 'json',
        error: function(){
            console.log('Error loading data');
        },
        success:function(data) {
            console.log(data);
            $.each(data['monthly'], function(key, value){
                var ls = '';
                ls += '<a class="lv-item" href="#"><div class="media"><div class="media-body"><div class="lv-title">' + value.name + '</div><small class="lv-small">' + value.startdate + ' ( ' + value.timeto + ' days left )</small></div></div></a>';
                $('#list-below30').append(ls);
            });
        }
    });

    $.ajax({
        url: base_url + 'api/loadUpcomingPlan/upper/-30',
        type: 'GET',
        dataType: 'json',
        error: function(){
            console.log('Error loading data');
        },
        success:function(data) {
            console.log(data);
            $.each(data['monthly'], function(key, value){
                var ls = '';
                ls += '<a class="lv-item" href="#"><div class="media"><div class="media-body"><div class="lv-title">' + value.name + '</div><small class="lv-small">' + value.startdate + ' ( ' + value.timeto + ' days left )</small></div></div></a>';
                $('#list-upper30').append(ls);
            });
        }
    });
    @endcan

    @can('Project Task-Read')
    $('#project-task-calendar').monthly({
        'mode' : 'event',
        'stylePast' : true,
        'dataType' : 'json',
        'jsonUrl' : base_url + 'grid/projecttask/api/loadTasks/all/all/all/all',
    });

    $('#btn-project-task-process').click(function() {
        var projecttaskpics = $('#project-task-select-pic').val();
        var projecttaskauthors = $('#project-task-select-author').val();
        var projecttasktypes = $('#project-task-select-types').val();
        var projecttaskprojects = $('#project-task-select-projects').val();

        if(projecttaskpics == null) {
            projecttaskpics = 'all';
        }

        if(projecttaskauthors == null) {
            projecttaskauthors = 'all';
        }

        if(projecttasktypes == null) {
            projecttasktypes = 'all';
        }

        if(projecttaskprojects == null) {
            projecttaskprojects = 'all';
        }

        $("#project-task-calendar").empty();
        $('#project-task-calendar').monthly({
            'mode' : 'event',
            'stylePast' : true,
            'dataType' : 'json',
            'jsonUrl' : base_url + 'grid/projecttask/api/loadTasks/' + projecttaskpics + '/' + projecttaskauthors + '/' + projecttasktypes + '/' + projecttaskprojects,
        });
    });
    @endcan
});
</script>
@endsection