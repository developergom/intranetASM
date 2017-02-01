@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Project<small>List of all Projects</small></h2>
        @can('Project-Create')
        <a href="{{ url('grid/project/create') }}" title="Create New Project"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Project-Approval')
                <li class="active"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Project-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
                @can('Project-Create')
                <li><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Project-Approval')
                <div role="tabpanel" class="tab-pane active" id="needchecking">
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_code" data-order="asc">Project Code</th>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="project_periode_start" data-order="asc">Period Start</th>
                                    <th data-column-id="project_periode_end" data-order="asc">Period End</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Project-Update')
                                        @can('Project-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Project-Approval')
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
                                    <th data-column-id="project_code" data-order="asc">Project Code</th>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="project_periode_start" data-order="asc">Period Start</th>
                                    <th data-column-id="project_periode_end" data-order="asc">Period End</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Project-Delete')
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
                @can('Project-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_code" data-order="asc">Project Code</th>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="project_periode_start" data-order="asc">Period Start</th>
                                    <th data-column-id="project_periode_end" data-order="asc">Period End</th>
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
                @can('Project-Create')
                <div role="tabpanel" class="tab-pane" id="canceled">
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="project_code" data-order="asc">Project Code</th>
                                    <th data-column-id="project_name" data-order="asc">Project Name</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="project_periode_start" data-order="asc">Period Start</th>
                                    <th data-column-id="project_periode_end" data-order="asc">Period End</th>
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
<script type="text/javascript">
var uid = '{{ Request::user()->user_id }}';
</script>
<script src="{{ url('js/grid/project.js') }}"></script>
@endsection