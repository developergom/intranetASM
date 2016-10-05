@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Application Settings Management<small>List of all Settings</small></h2>
        @can('Application Settings-Create')
        <a href="{{ url('config/setting/create') }}" title="Create New Setting"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="setting_code" data-order="asc">Code</th>
                    <th data-column-id="setting_name" data-order="asc">Name</th>
                    <th data-column-id="setting_desc" data-order="asc">Description</th>
                    @can('Application Settings-Update')
                        @can('Application Settings-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Application Settings-Delete')
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
<script src="{{ url('js/config/setting.js') }}"></script>
@endsection