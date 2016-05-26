@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Action Control Management<small>List of all action controls</small></h2>
        <a href="{{ url('master/action/create') }}" title="Create New Action Control"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="action_name" data-order="asc">Action Control Name</th>
                    <th data-column-id="action_alias" data-order="asc">Alias</th>
                    <th data-column-id="action_desc" data-order="asc">Description</th>
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
<script src="{{ url('js/master/action.js') }}"></script>
@endsection