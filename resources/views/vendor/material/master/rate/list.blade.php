@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Rates Management<small>List of all rates</small></h2>
        @can('Rates Management-Create')
        <a href="{{ url('master/rate/create') }}" title="Create New Rate"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="advertise_rate_type_name" data-order="asc">Type</th>
                    <th data-column-id="rate_name" data-order="asc">Name</th>
                    <th data-column-id="end_valid_date" data-order="asc">Valid Until</th>
                    <th data-column-id="gross_rate" data-converter="price" data-order="asc">Gross Rate</th>
                    @can('Rates Management-Update')
                        @can('Rates Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Rates Management-Delete')
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

@section('vendorjs')
<script src="{{ url('js/jquery.price_format.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/rate.js') }}"></script>
@endsection