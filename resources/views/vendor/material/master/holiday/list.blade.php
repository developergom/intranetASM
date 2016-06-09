@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Holidays Management<small>List of all holidays</small></h2>
        <a href="{{ url('master/holiday/create') }}" title="Create New Holiday"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="holiday_name" data-order="asc">Holiday Name</th>
                    <th data-column-id="holiday_date" data-converter="datetime" data-order="asc">Date</th>
                    <th data-column-id="link" data-formatter="link" data-sortable="false">Action</th>
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