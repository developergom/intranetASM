@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Advertise Positions Management<small>List of all advertise positions</small></h2>
        @can('Advertise Positions Management-Create')
        <a href="{{ url('master/advertiseposition/create') }}" title="Create New Advertise Position"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="advertise_position_name" data-order="asc">Name</th>
                    <th data-column-id="advertise_position_desc" data-order="asc">Description</th>
                    @can('Advertise Positions Management-Update')
                        @can('Advertise Positions Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Advertise Positions Management-Delete')
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
<script src="{{ url('js/master/advertiseposition.js') }}"></script>
@endsection