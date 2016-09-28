@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Agenda Plan<small>List of all Agenda Plans</small></h2>
        @can('Agenda Plan-Create')
        <a href="{{ url('agenda/plan/create') }}" title="Create New Agenda"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="agenda_date" data-order="asc">Date</th>
                    <th data-column-id="agenda_type_name" data-order="asc">Type</th>
                    <th data-column-id="agenda_destination" data-order="asc">Destination</th>
                    <th data-column-id="user_firstname" data-order="asc">Author</th>
                    @can('Agenda Plan-Update')
                        @can('Agenda Plan-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Agenda Plan-Delete')
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
<script src="{{ url('js/agenda/agenda.js') }}"></script>
@endsection