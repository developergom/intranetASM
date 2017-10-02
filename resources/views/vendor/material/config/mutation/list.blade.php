@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Mutations Management<small>List of mutations</small></h2>
        <a href="{{ url('config/mutation/create') }}" title="Create New Mutation"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="from_firstname" data-order="asc">From</th>
                    <th data-column-id="to_firstname" data-order="asc">To</th>
                    <th data-column-id="inventory_planner_title" data-order="asc">Inventory Planner</th>
                    <th data-column-id="proposal_name" data-order="asc">Proposal Name</th>
                    <th data-column-id="summary_order_no" data-order="asc">Summary Order No</th>
                    <th data-column-id="created_at" data-order="asc">Created At</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/config/mutation.js') }}"></script>
@endsection