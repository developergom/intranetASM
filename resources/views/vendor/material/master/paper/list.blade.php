@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Paper Types Management<small>List of all paper types</small></h2>
        <a href="{{ url('master/paper/create') }}" title="Create New Paper Type"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="paper_name" data-order="asc">Name</th>
                    <th data-column-id="paper_width" data-order="asc">Width</th>
                    <th data-column-id="paper_length" data-order="asc">Length</th>
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
<script src="{{ url('js/master/paper.js') }}"></script>
@endsection