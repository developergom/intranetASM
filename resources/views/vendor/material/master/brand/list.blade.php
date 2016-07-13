@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Brands Management<small>List of all brands</small></h2>
        <a href="{{ url('master/brand/create') }}" title="Create New Brand"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="brand_code" data-order="asc">Code</th>
                    <th data-column-id="industry_name" data-order="asc">Industry</th>
                    <th data-column-id="subindustry_name" data-order="asc">Sub Industry</th>
                    <th data-column-id="brand_name" data-order="asc">Name</th>
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
<script src="{{ url('js/master/brand.js') }}"></script>
@endsection