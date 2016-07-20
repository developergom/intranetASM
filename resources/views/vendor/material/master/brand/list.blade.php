@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Brands Management<small>List of all brands</small></h2>
        @can('Brands Management-Create')
        <a href="{{ url('master/brand/create') }}" title="Create New Brand"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="brand_code" data-order="asc">Code</th>
                    <th data-column-id="industry_name" data-order="asc">Industry</th>
                    <th data-column-id="subindustry_name" data-order="asc">Sub Industry</th>
                    <th data-column-id="brand_name" data-order="asc">Name</th>
                    @can('Brands Management-Update')
                        @can('Brands Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Brands Management-Delete')
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
<script src="{{ url('js/master/brand.js') }}"></script>
@endsection