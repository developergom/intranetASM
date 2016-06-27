@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Clients Management<small>List of all clients</small></h2>
        <a href="{{ url('master/client/create') }}" title="Create New Client"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="client_type_name" data-order="asc">Type</th>
                    <th data-column-id="client_name" data-order="asc">Name</th>
                    <th data-column-id="client_formal_name" data-order="asc">Formal Name</th>
                    <th data-column-id="client_email" data-order="asc">Email</th>
                    <th data-column-id="client_phone" data-order="asc">Phone</th>
                    <th data-column-id="link" data-formatter="link" data-sortable="false">Action</th>
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