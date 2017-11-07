@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Target Management<small>List of all target</small></h2>
        @can('Target Management-Create')
        <a href="{{ url('master/target/create') }}" title="Create New Target"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="target_code" data-order="asc">Code</th>
                    <th data-column-id="media_name" data-order="asc">Media</th>
                    <th data-column-id="industry_name" data-order="asc">Industry</th>
                    <th data-column-id="target_month" data-order="asc">Month</th>
                    <th data-column-id="target_year" data-order="asc">Year</th>
                    <th data-column-id="target_amount" data-converter="price" data-order="asc">Amount</th>
                    @can('Target Management-Update')
                        @can('Target Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Target Management-Delete')
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
<script src="{{ url('js/master/target.js') }}"></script>
@endsection