@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Project<small>List of all Projects</small></h2>
        @can('Project-Create')
        <a href="{{ url('grid/project/create') }}" title="Create New Project"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="project_code" data-order="asc">Code</th>
                    <th data-column-id="project_name" data-order="asc">Name</th>
                    <th data-column-id="client_name" data-order="asc">Client</th>
                    <th data-column-id="user_firstname" data-order="asc">Author</th>
                    @can('Project-Update')
                        @can('Project-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Project-Delete')
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
<script type="text/javascript">
var uid = '{{ Request::user()->user_id }}';
</script>
<script src="{{ url('js/grid/project.js') }}"></script>
@endsection