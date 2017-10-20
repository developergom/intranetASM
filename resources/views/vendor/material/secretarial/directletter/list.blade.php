@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Direct Letter<small>List of all direct letters</small></h2>
        @can('Direct Letter-Create')
        <a href="{{ url('secretarial/directletter/create') }}" title="Create New Order"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                    <th data-column-id="letter_type_name" data-order="asc">Letter Type</th>
                    <th data-column-id="letter_to" data-order="asc">Letter To</th>
                    <th data-column-id="letter_no" data-order="asc">Letter No</th>
                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                    @can('Direct Letter-Update')
                        @can('Direct Letter-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Direct Letter-Delete')
                            <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                        @endcan
                    @endcan
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/secretarial/directletter.js') }}"></script>
@endsection