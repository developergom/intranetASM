@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Publisher Management<small>List of all publisher</small></h2>
        @can('Publishers Management-Create')
        <a href="{{ url('master/publisher/create') }}" title="Create New Publisher"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="publisher_code" data-order="asc">Code</th>
                    <th data-column-id="publisher_name" data-order="asc">Name</th>
                    <th data-column-id="publisher_desc" data-order="asc">Description</th>
                    @can('Publishers Management-Update')
                        @can('Publishers Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Publishers Management-Delete')
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
<script src="{{ url('js/master/publisher.js') }}"></script>
@endsection