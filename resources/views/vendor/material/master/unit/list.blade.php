@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Units Management<small>List of all units</small></h2>
        <a href="{{ url('master/unit/create') }}" title="Create New Unit"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="unit_code" data-order="asc">Code</th>
                    <th data-column-id="unit_name" data-order="asc">Name</th>
                    <th data-column-id="unit_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/unit.js') }}"></script>
@endsection