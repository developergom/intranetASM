@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Sub Industries Management<small>List of all sub industries</small></h2>
        @can('Sub Industries Management-Create')
        <a href="{{ url('master/subindustry/create') }}" title="Create New Sub Industry"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="subindustry_code" data-order="asc">Code</th>
                    <th data-column-id="industry_name" data-order="asc">Industry</th>
                    <th data-column-id="subindustry_name" data-order="asc">Name</th>
                    <th data-column-id="subindustry_desc" data-order="asc">Description</th>
                    @can('Sub Industries Management-Update')
                        @can('Sub Industries Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Sub Industries Management-Delete')
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
<script src="{{ url('js/master/subindustry.js') }}"></script>
@endsection