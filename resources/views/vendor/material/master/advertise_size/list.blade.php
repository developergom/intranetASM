@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Advertise Sizes Management<small>List of all advertise sizes</small></h2>
        @can('Advertise Sizes Management-Create')
        <a href="{{ url('master/advertisesize/create') }}" title="Create New Advertise Size"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="advertise_size_code" data-order="asc">Code</th>
                    <th data-column-id="advertise_size_name" data-order="asc">Name</th>
                    <th data-column-id="advertise_size_width" data-order="asc">Width</th>
                    <th data-column-id="advertise_size_length" data-order="asc">Length</th>
                    <th data-column-id="unit_code" data-order="asc">Unit</th>
                    @can('Advertise Sizes Management-Update')
                        @can('Advertise Sizes Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Advertise Sizes Management-Delete')
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
<script src="{{ url('js/master/advertisesize.js') }}"></script>
@endsection