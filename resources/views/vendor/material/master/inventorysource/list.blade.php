@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Inventory Sources Management<small>List of all inventory sources</small></h2>
        @can('Inventory Sources Management-Create')
        <a href="{{ url('master/inventorysource/create') }}" title="Create New Inventory Source"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="inventory_source_name" data-order="asc">Name</th>
                    <th data-column-id="inventory_source_desc" data-order="asc">Description</th>
                    @can('Inventory Sources Management-Update')
                        @can('Inventory Sources Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Inventory Sources Management-Delete')
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
<script src="{{ url('js/master/inventorysource.js') }}"></script>
@endsection