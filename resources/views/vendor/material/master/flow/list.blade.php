@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Flows Management<small>List of all flows</small></h2>
        @can('Flows Management-Create')
        <a href="{{ url('master/flow/create') }}" title="Create New Flow"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="flow_group_name" data-order="asc">Flow Group Name</th>
                    <th data-column-id="flow_name" data-order="asc">Flow Name</th>
                    <th data-column-id="flow_no" data-order="asc">No</th>
                    <th data-column-id="flow_by" data-order="asc">By</th>
                    <th data-column-id="role_name" data-order="asc">Role</th>
                    @can('Flows Management-Update')
                        @can('Flows Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Flows Management-Delete')
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
<script src="{{ url('js/master/flow.js') }}"></script>
@endsection