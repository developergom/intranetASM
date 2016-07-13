@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Industries Management<small>List of all industries</small></h2>
        <a href="{{ url('master/industry/create') }}" title="Create New Industry"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="industry_code" data-order="asc">Code</th>
                    <th data-column-id="industry_name" data-order="asc">Name</th>
                    <th data-column-id="industry_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/industry.js') }}"></script>
@endsection