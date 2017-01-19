@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Project Task Types Management<small>List of all project task types</small></h2>
        @can('Project Task Types Management-Create')
        <a href="{{ url('master/projecttasktype/create') }}" title="Create New Project Task Type"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="project_task_type_name" data-order="asc">Name</th>
                    <th data-column-id="user_firstname" data-order="asc">User Approval</th>
                    <th data-column-id="project_task_type_desc" data-order="asc">Description</th>
                    @can('Project Task Types Management-Update')
                        @can('Project Task Types Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Project Task Types Management-Delete')
                            <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
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
@endsection

@section('customjs')
<script src="{{ url('js/master/projecttasktype.js') }}"></script>
@endsection