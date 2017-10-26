@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Letter<small>List of all letters</small></h2>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                    <th data-column-id="letter_type_name" data-order="asc">Letter Type</th>
                    <th data-column-id="letter_to" data-order="asc">Letter To</th>
                    <th data-column-id="letter_no" data-order="asc">Letter No</th>
                    <th data-column-id="letter_source" data-order="asc">Source</th>
                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/secretarial/allletter.js') }}"></script>
@endsection