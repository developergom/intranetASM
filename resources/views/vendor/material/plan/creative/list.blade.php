@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Creative Plans<small>List of all creative plan</small></h2>
        @can('Creative Plan-Create')
        <a href="{{ url('plan/creativeplan/create') }}" title="Create New Creative Plan"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Creative Plan-Approval')
                <li class="active"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Creative Plan-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
                @can('Creative Plan-Create')
                <li><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Creative Plan-Approval')
                <div role="tabpanel" class="tab-pane active" id="needchecking">
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="creative_format_name" data-order="asc">Format</th>
                                    <th data-column-id="creative_name" data-order="asc">Name</th>
                                    <th data-column-id="media_category_name" data-order="asc">Category</th>
                                    <th data-column-id="creative_width" data-order="asc">Width</th>
                                    <th data-column-id="creative_height" data-order="asc">Height</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Creative Plan-Update')
                                        @can('Creative Plan-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Creative Plan-Approval')
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
                                    <th data-column-id="creative_format_name" data-order="asc">Format</th>
                                    <th data-column-id="creative_name" data-order="asc">Name</th>
                                    <th data-column-id="media_category_name" data-order="asc">Category</th>
                                    <th data-column-id="creative_width" data-order="asc">Width</th>
                                    <th data-column-id="creative_height" data-order="asc">Height</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Creative Plan-Delete')
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
                @can('Creative Plan-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="creative_format_name" data-order="asc">Format</th>
                                    <th data-column-id="creative_name" data-order="asc">Name</th>
                                    <th data-column-id="media_category_name" data-order="asc">Category</th>
                                    <th data-column-id="creative_width" data-order="asc">Width</th>
                                    <th data-column-id="creative_height" data-order="asc">Height</th>
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
                @can('Creative Plan-Create')
                <div role="tabpanel" class="tab-pane" id="canceled">
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="creative_format_name" data-order="asc">Format</th>
                                    <th data-column-id="creative_name" data-order="asc">Name</th>
                                    <th data-column-id="media_category_name" data-order="asc">Category</th>
                                    <th data-column-id="creative_width" data-order="asc">Width</th>
                                    <th data-column-id="creative_height" data-order="asc">Height</th>
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
<script src="{{ url('js/plan/creative.js') }}"></script>
@endsection