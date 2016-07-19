@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Action Control Management<small>List of all action controls</small></h2>
        @can('Action Controls Management-Create')
        <a href="{{ url('master/action/create') }}" title="Create New Action Control"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="action_name" data-order="asc">Action Control Name</th>
                    <th data-column-id="action_alias" data-order="asc">Alias</th>
                    <th data-column-id="action_desc" data-order="asc">Description</th>
                    @can('Action Controls Management-Update')
                        @can('Action Controls Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Action Controls Management-Delete')
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
<script src="{{ url('js/master/action.js') }}"></script>
@endsection