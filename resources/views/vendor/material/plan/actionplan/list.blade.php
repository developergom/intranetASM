@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Action Plan<small>List of all action plan</small></h2>
        @can('Action Plan-Create')
        <a href="{{ url('plan/actionplan/create') }}" title="Create New Action Plan"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="action_type_name" data-order="asc">Type</th>
                    <th data-column-id="action_plan_title" data-order="asc">Title</th>
                    <th data-column-id="action_plan_startdate" data-order="asc">Start Period</th>
                    <th data-column-id="action_plan_enddate" data-order="asc">End Period</th>
                    @can('Action Plan-Update')
                        @can('Action Plan-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Action Plan-Delete')
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
<script src="{{ url('js/plan/actionplan.js') }}"></script>
@endsection