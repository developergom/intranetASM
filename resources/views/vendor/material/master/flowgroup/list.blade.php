@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Flow Groups Management<small>List of all flow groups</small></h2>
        @can('Flow Groups Management-Create')
        <a href="{{ url('master/flowgroup/create') }}" title="Create New Flow Group"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="flow_group_name" data-order="asc">Flow Group Name</th>
                    <th data-column-id="module_url" data-order="asc">URL</th>
                    <th data-column-id="flow_group_desc" data-order="asc">Description</th>
                    @can('Flow Groups Management-Update')
                        @can('Flow Groups Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Flow Groups Management-Delete')
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
<script src="{{ url('js/master/flowgroup.js') }}"></script>
@endsection