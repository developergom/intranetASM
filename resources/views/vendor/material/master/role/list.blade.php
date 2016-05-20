@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header"><h2>Role Management<small>List of all roles</small></h2></div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="role_name" data-order="asc">Role Name</th>
                    <th data-column-id="role_desc" data-order="desc">Description</th>
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
<script src="{{ url('js/master/role.js') }}"></script>
@endsection