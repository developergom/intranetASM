@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>User Management<small>List of all users</small></h2>
        <a href="{{ url('user/create') }}" title="Create New User"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="user_name" data-order="asc">Username</th>
                    <th data-column-id="user_firstname" data-order="asc">First Name</th>
                    <th data-column-id="user_lastname" data-order="asc">Last Name</th>
                    <th data-column-id="user_email" data-order="asc">Email</th>
                    <th data-column-id="user_phone" data-order="asc">Phone</th>
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
<script src="{{ url('js/app/user.js') }}"></script>
@endsection