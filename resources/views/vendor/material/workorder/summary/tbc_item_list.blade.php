@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>TBC Items List<small>List of all To Be Confirmed Summary Items</small></h2>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="summary_item_period_start" data-order="asc">Show Date</th>
                    <th data-column-id="summary_order_no" data-order="asc">Order No</th>
                    <th data-column-id="summary_item_title" data-order="asc">Title</th>
                    <th data-column-id="client_name" data-order="asc">Client</th>
                    <th data-column-id="summary_item_nett" data-converter="price" data-order="asc">Nett Rate</th>
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
<script src="{{ url('js/workorder/tbc_item_list.js') }}"></script>
@endsection