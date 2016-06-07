@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Media Group Management<small>List of all media groups</small></h2>
        <a href="{{ url('master/mediagroup/create') }}" title="Create New Media Group"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="media_group_code" data-order="asc">Code</th>
                    <th data-column-id="media_group_name" data-order="asc">Name</th>
                    <th data-column-id="media_group_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/mediagroup.js') }}"></script>
@endsection