@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Menu Management<small>List of all menus</small></h2>
        <a href="{{ url('master/menu/create') }}" title="Create New Menu"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="menu_name" data-order="asc">Menu Name</th>
                    <th data-column-id="module_url" data-order="asc">URL</th>
                    <th data-column-id="menu_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/menu.js') }}"></script>
@endsection