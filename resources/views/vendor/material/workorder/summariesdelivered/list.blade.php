@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Summaries Delivered<small>List of all summaries delivered</small></h2>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                    <th data-column-id="proposal_name" data-order="asc">Title</th>
                    <th data-column-id="summary_order_no" data-order="asc">Order No</th>
                    <th data-column-id="pic_firstname" data-order="asc">PIC</th>
                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                    @can('Summaries Delivered-Approval')
                        <th data-column-id="link" data-formatter="link-ra" data-sortable="false">Action</th>
                    @else
                        <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
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
<script src="{{ url('js/workorder/summariesdelivered.js') }}"></script>
@endsection