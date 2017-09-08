@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Studios Management<small>List of all studios</small></h2>
        @can('Studios Management-Create')
        <a href="{{ url('master/studio/create') }}" title="Create New Studio"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="studio_name" data-order="asc">Name</th>
                    <th data-column-id="studio_desc" data-order="asc">Desc</th>
                    @can('Studios Management-Update')
                        @can('Studios Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Studios Management-Delete')
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
<script src="{{ url('js/master/studio.js') }}"></script>
@endsection