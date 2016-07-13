@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Role Management<small>List of all roles</small></h2>
        <!-- <ul class="actions">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="zmdi zmdi-more-vert"></i>
                </a>
                
                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="#">Create New Role</a>
                    </li>
                </ul>
            </li>
            <li></li>
        </ul> -->
        <a href="{{ url('master/role/create') }}" title="Create New Role"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
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