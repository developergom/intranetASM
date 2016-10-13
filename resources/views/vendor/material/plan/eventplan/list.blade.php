@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Event Plans<small>List of all event plan</small></h2>
        @can('Event Plan-Create')
        <a href="{{ url('plan/eventplan/create') }}" title="Create New Event Plan"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Event Plan-Approval')
                <li class="active"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Event Plan-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
                @can('Event Plan-Create')
                <li><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Event Plan-Approval')
                <div role="tabpanel" class="tab-pane active" id="needchecking">
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="event_type_name" data-order="asc">Type</th>
                                    <th data-column-id="event_plan_name" data-order="asc">Name</th>
                                    <th data-column-id="event_plan_viewer" data-order="asc">Total Viewer</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Month</th>
                                    <th data-column-id="event_plan_year" data-order="asc">Year</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Event Plan-Update')
                                        @can('Event Plan-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Event Plan-Approval')
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
                                    <th data-column-id="event_type_name" data-order="asc">Type</th>
                                    <th data-column-id="event_plan_name" data-order="asc">Name</th>
                                    <th data-column-id="event_plan_viewer" data-order="asc">Total Viewer</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Month</th>
                                    <th data-column-id="event_plan_year" data-order="asc">Year</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Event Plan-Delete')
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
                @can('Event Plan-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="event_type_name" data-order="asc">Type</th>
                                    <th data-column-id="event_plan_name" data-order="asc">Name</th>
                                    <th data-column-id="event_plan_viewer" data-order="asc">Total Viewer</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Month</th>
                                    <th data-column-id="event_plan_year" data-order="asc">Year</th>
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
                @can('Event Plan-Create')
                <div role="tabpanel" class="tab-pane" id="canceled">
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="event_type_name" data-order="asc">Type</th>
                                    <th data-column-id="event_plan_name" data-order="asc">Name</th>
                                    <th data-column-id="event_plan_viewer" data-order="asc">Total Viewer</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Month</th>
                                    <th data-column-id="event_plan_year" data-order="asc">Year</th>
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
<script src="{{ url('js/plan/eventplan.js') }}"></script>
@endsection