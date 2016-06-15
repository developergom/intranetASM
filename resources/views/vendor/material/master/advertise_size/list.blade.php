@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Advertise Sizes Management<small>List of all advertise sizes</small></h2>
        <a href="{{ url('master/advertisesize/create') }}" title="Create New Advertise Size"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="advertise_size_code" data-order="asc">Code</th>
                    <th data-column-id="advertise_size_name" data-order="asc">Name</th>
                    <th data-column-id="advertise_size_width" data-order="asc">Width</th>
                    <th data-column-id="advertise_size_length" data-order="asc">Length</th>
                    <th data-column-id="unit_code" data-order="asc">Unit</th>
                    <th data-column-id="link" data-formatter="link" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/master/advertisesize.js') }}"></script>
@endsection