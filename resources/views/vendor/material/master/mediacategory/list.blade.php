@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Media Category Management<small>List of all media categories</small></h2>
        <a href="{{ url('master/mediacategory/create') }}" title="Create New Media Category"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="media_category_name" data-order="asc">Name</th>
                    <th data-column-id="media_category_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/mediacategory.js') }}"></script>
@endsection