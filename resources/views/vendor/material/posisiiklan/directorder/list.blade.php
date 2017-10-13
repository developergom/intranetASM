@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Direct Orders<small>List of all Direct Orders</small></h2>
        @can('Direct Order-Create')
        <a href="{{ url('posisi-iklan/direct-order/create') }}" title="Create New Direct Order"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="updated_at" data-order="asc">Last Updated</th>
                    <th data-column-id="summary_item_title" data-order="asc">Title</th>
                    <th data-column-id="rate_name" data-order="asc">Rate Name</th>
                    <th data-column-id="client_name" data-order="asc">Client</th>
                    <th data-column-id="summary_item_period_start" data-order="asc">Show Date</th>
                    <th data-column-id="user_firstname" data-order="asc">Order By</th>
                    @can('Direct Order-Update')
                        @can('Direct Order-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Direct Order-Delete')
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
<script src="{{ url('js/posisiiklan/directorder.js') }}"></script>
@endsection