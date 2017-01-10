@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Proposal Types Management<small>List of all proposal types</small></h2>
        @can('Proposal Types Management-Create')
        <a href="{{ url('master/proposaltype/create') }}" title="Create New Proposal Type"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="proposal_type_name" data-order="asc">Name</th>
                    <th data-column-id="proposal_type_duration" data-order="asc">Duration (day)</th>
                    <th data-column-id="proposal_type_desc" data-order="asc">Description</th>
                    @can('Proposal Types Management-Update')
                        @can('Proposal Types Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Proposal Types Management-Delete')
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
<script src="{{ url('js/master/proposaltype.js') }}"></script>
@endsection