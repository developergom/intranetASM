@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Clients Management<small>List of all clients</small></h2>
        @can('Clients Management-Create')
        <a href="{{ url('master/client/create') }}" title="Create New Client"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="client_type_name" data-order="asc">Type</th>
                    <th data-column-id="client_name" data-order="asc">Name</th>
                    <th data-column-id="client_formal_name" data-order="asc">Formal Name</th>
                    <th data-column-id="client_email" data-order="asc">Email</th>
                    <th data-column-id="client_phone" data-order="asc">Phone</th>
                    @can('Clients Management-Create')
                        @can('Clients Management-Update')
                            @can('Clients Management-Delete')
                                <th data-column-id="link" data-formatter="link-crud" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-cru" data-sortable="false">Action</th>
                            @endcan
                        @else
                            @can('Clients Management-Delete')
                                <th data-column-id="link" data-formatter="link-crd" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-cr" data-sortable="false">Action</th>
                            @endcan
                        @endcan
                    @else
                        @can('Clients Management-Update')
                            @can('Clients Management-Delete')
                                <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                            @endcan
                        @else
                            @can('Clients Management-Delete')
                                <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                            @endcan
                        @endcan
                    @endcan
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>  

@include('vendor.material.master.client.modal')

@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/clientcontact.js') }}"></script>
<script src="{{ url('js/master/client.js') }}"></script>
@endsection