@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Sub Industries Management<small>List of all sub industries</small></h2>
        <a href="{{ url('master/subindustry/create') }}" title="Create New Sub Industry"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="subindustry_code" data-order="asc">Code</th>
                    <th data-column-id="industry_name" data-order="asc">Industry</th>
                    <th data-column-id="subindustry_name" data-order="asc">Name</th>
                    <th data-column-id="subindustry_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/subindustry.js') }}"></script>
@endsection