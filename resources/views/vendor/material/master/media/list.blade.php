@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Media Management<small>List of all media</small></h2>
        <a href="{{ url('master/media/create') }}" title="Create New Media"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="media_code" data-order="asc">Code</th>
                    <th data-column-id="media_name" data-order="asc">Name</th>
                    <th data-column-id="media_group_name" data-order="asc">Group</th>
                    <th data-column-id="media_category_name" data-order="asc">Category</th>
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
<script src="{{ url('js/master/media.js') }}"></script>
@endsection