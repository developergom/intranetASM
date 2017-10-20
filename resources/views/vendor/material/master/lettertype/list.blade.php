@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Letter Types Management<small>List of all letter types</small></h2>
        @can('Letter Types Management-Create')
        <a href="{{ url('master/lettertype/create') }}" title="Create New Letter Type"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="letter_type_code" data-order="asc">Code</th>
                    <th data-column-id="letter_type_name" data-order="asc">Name</th>
                    <th data-column-id="letter_type_desc" data-order="asc">Description</th>
                    @can('Letter Types Management-Update')
                        @can('Letter Types Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Letter Types Management-Delete')
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
<script src="{{ url('js/master/lettertype.js') }}"></script>
@endsection