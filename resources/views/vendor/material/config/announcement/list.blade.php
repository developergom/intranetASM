@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Announcement Management<small>List of all Announcement</small></h2>
        @can('Announcement Management-Create')
        <a href="{{ url('config/announcement/create') }}" title="Create New Announcement"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="announcement_title" data-order="asc">Title</th>
                    <th data-column-id="announcement_startdate" data-converter="datetime" data-order="asc">Start Date</th>
                    <th data-column-id="announcement_enddate" data-converter="datetime" data-order="asc">End Date</th>
                    @can('Announcement Management-Update')
                        @can('Announcement Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Announcement Management-Delete')
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
<script src="{{ url('js/config/announcement.js') }}"></script>
@endsection