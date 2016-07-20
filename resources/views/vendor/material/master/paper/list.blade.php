@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Paper Types Management<small>List of all paper types</small></h2>
        @can('Paper Types Management-Create')
        <a href="{{ url('master/paper/create') }}" title="Create New Paper Type"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="paper_name" data-order="asc">Name</th>
                    <th data-column-id="paper_width" data-order="asc">Width</th>
                    <th data-column-id="paper_length" data-order="asc">Length</th>
                    <th data-column-id="unit_code" data-order="asc">Unit</th>
                    @can('Paper Types Management-Update')
                        @can('Paper Types Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Paper Types Management-Delete')
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
<script src="{{ url('js/master/paper.js') }}"></script>
@endsection