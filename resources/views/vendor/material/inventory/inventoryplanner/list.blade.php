@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Inventories Planner<small>List of all inventory planner</small></h2>
        @can('Inventory Planner-Create')
        <a href="{{ url('inventory/inventoryplanner/create') }}" title="Create New Inventory Planner"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                <?php $active_tab = 0; ?>
                <?php $active_tab_body = 0; ?>
                @can('Inventory Planner-Approval')
                <li class="{!! ($active_tab==0) ? 'active' : '' !!}"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                    <?php $active_tab = 1; ?>
                @endcan
                @can('Inventory Planner-Read')
                <li class="{!! ($active_tab==0) ? 'active' : '' !!}"><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                    <?php $active_tab = 1; ?>
                @endcan
                @can('Inventory Planner-Create')
                <li class="{!! ($active_tab==0) ? 'active' : '' !!}"><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                    <?php $active_tab = 1; ?>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Inventory Planner-Approval')
                <div role="tabpanel" class="tab-pane {!! ($active_tab_body==0) ? 'active' : '' !!}" id="needchecking">
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="inventory_category_name" data-order="asc">Category</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Implementation</th>
                                    <th data-column-id="inventory_planner_year" data-order="asc">Year</th>
                                    <th data-column-id="inventory_planner_title" data-order="asc">Title</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Inventory Planner-Update')
                                        @can('Inventory Planner-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Inventory Planner-Approval')
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
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="inventory_category_name" data-order="asc">Category</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Implementation</th>
                                    <th data-column-id="inventory_planner_year" data-order="asc">Year</th>
                                    <th data-column-id="inventory_planner_title" data-order="asc">Title</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Inventory Planner-Delete')
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
                    <?php $active_tab_body = 1; ?>
                @endcan
                @can('Inventory Planner-Read')
                <div role="tabpanel" class="tab-pane {!! ($active_tab_body==0) ? 'active' : '' !!}" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="inventory_category_name" data-order="asc">Category</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Implementation</th>
                                    <th data-column-id="inventory_planner_year" data-order="asc">Year</th>
                                    <th data-column-id="inventory_planner_title" data-order="asc">Title</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <?php $active_tab_body = 1; ?>
                @endcan
                @can('Inventory Planner-Create')
                <div role="tabpanel" class="tab-pane {!! ($active_tab_body==0) ? 'active' : '' !!}" id="canceled">
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="inventory_category_name" data-order="asc">Category</th>
                                    <th data-column-id="implementation_month_name" data-order="asc">Implementation</th>
                                    <th data-column-id="inventory_planner_year" data-order="asc">Year</th>
                                    <th data-column-id="inventory_planner_title" data-order="asc">Title</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                    <?php $active_tab_body = 1; ?>
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
@can('Proposal-Create')
var cancreateproposal = true;
@else
var cancreateproposal = false;
@endcan
</script>
<script src="{{ url('js/inventory/inventoryplanner.js') }}"></script>
@endsection