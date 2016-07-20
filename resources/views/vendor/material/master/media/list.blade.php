@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Media Management<small>List of all media</small></h2>
        @can('Media Management-Create')
        <a href="{{ url('master/media/create') }}" title="Create New Media"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="media_code" data-order="asc">Code</th>
                    <th data-column-id="media_name" data-order="asc">Name</th>
                    <th data-column-id="media_group_name" data-order="asc">Group</th>
                    <th data-column-id="media_category_name" data-order="asc">Category</th>
                    @can('Media Management-Create')
                        @can('Media Management-Update')
                            @can('Media Management-Delete')
                                <th data-column-id="link" data-formatter="link-crud" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-cru" data-sortable="false">Action</th>
                            @endcan
                        @else
                            @can('Media Management-Delete')
                                <th data-column-id="link" data-formatter="link-crd" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-cr" data-sortable="false">Action</th>
                            @endcan
                        @endcan
                    @else
                        @can('Media Management-Update')
                            @can('Media Management-Delete')
                                <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                            @endcan
                        @else
                            @can('Media Management-Delete')
                                <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
                            @else
                                <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                            @endcan
                        @endcan
                    @endcan
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@include('vendor.material.master.media.modal')

@endsection

@section('vendorjs')
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/mediaedition.js') }}"></script>
<script src="{{ url('js/master/media.js') }}"></script>
@endsection