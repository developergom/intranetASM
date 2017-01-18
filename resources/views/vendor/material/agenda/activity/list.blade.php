@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Activity<small>List of all Activities</small></h2>
        @can('Activity-Create')
        <a href="{{ url('agenda/activity/create') }}" title="Create New Activity"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="activity_date" data-converter="datetime" data-order="asc">Date</th>
                    <th data-column-id="activity_type_name" data-order="asc">Type</th>
                    <th data-column-id="activity_destination" data-order="asc">Destination</th>
                    <th data-column-id="activity_status" data-order="asc">Status</th>
                    <th data-column-id="user_firstname" data-order="asc">Author</th>
                    @can('Activity-Update')
                        @can('Activity-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Activity-Delete')
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
<script type="text/javascript">
var uid = '{{ Request::user()->user_id }}';
</script>
<script src="{{ url('js/agenda/activity.js') }}"></script>
@endsection