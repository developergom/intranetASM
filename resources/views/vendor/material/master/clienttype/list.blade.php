@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Client Types Management<small>List of all client types</small></h2>
        <a href="{{ url('master/clienttype/create') }}" title="Create New Client Type"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="client_type_name" data-order="asc">Name</th>
                    <th data-column-id="client_type_desc" data-order="asc">Description</th>
                    <th data-column-id="link" data-formatter="link" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/master/clienttype.js') }}"></script>
@endsection