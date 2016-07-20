@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Holidays Management<small>List of all holidays</small></h2>
        @can('Holidays Management-Create')
        <a href="{{ url('master/holiday/create') }}" title="Create New Holiday"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="holiday_name" data-order="asc">Holiday Name</th>
                    <th data-column-id="holiday_date" data-converter="datetime" data-order="asc">Date</th>
                    @can('Holidays Management-Update')
                        @can('Holidays Management-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Holidays Management-Delete')
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

@section('vendorjs')
<script src="{{ url('js/moment.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/holiday.js') }}"></script>
@endsection