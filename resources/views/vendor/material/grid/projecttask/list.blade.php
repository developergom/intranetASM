@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Project Tasks<small>List of all project tasks</small></h2>
        @can('Project Task-Create')
        <a href="{{ url('grid/projecttask/create') }}" title="Create New Project Task"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Project Task-Approval')
                <li class="active"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Project Task-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
                @can('Project Task-Create')
                <li><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Project Task-Approval')
                <div role="tabpanel" class="tab-pane active" id="needchecking">
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="project_task_name" data-order="asc">Task Name</th>
                                    <th data-column-id="project_task_type_name" data-order="asc">Task Type</th>
                                    <th data-column-id="project_task_deadline" data-order="asc">Deadline</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Project Task-Update')
                                        @can('Project Task-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Project Task-Approval')
                                            <th data-column-id="link" data-formatter="link-ra" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                        @endcan
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>                 
                </div>
                <div role="tabpanel" class="tab-pane" id="onprocess">
                    <div class="table-responsive">
                        <table id="grid-data-onprocess" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="project_task_name" data-order="asc">Task Name</th>
                                    <th data-column-id="project_task_type_name" data-order="asc">Task Type</th>
                                    <th data-column-id="project_task_deadline" data-order="asc">Deadline</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Project Task-Delete')
                                        <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
                                    @else
                                        <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
                @can('Project Task-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="project_task_name" data-order="asc">Task Name</th>
                                    <th data-column-id="project_task_type_name" data-order="asc">Task Type</th>
                                    <th data-column-id="project_task_deadline" data-order="asc">Deadline</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
                @can('Project Task-Create')
                <div role="tabpanel" class="tab-pane" id="canceled">
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="project_task_name" data-order="asc">Task Name</th>
                                    <th data-column-id="project_task_type_name" data-order="asc">Task Type</th>
                                    <th data-column-id="project_task_deadline" data-order="asc">Deadline</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        </div>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/grid/projecttask.js') }}"></script>
@endsection