@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Posisi Iklan Item Tasks<small>List of all posisi iklan item tasks</small></h2>
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Posisi Iklan Item Task-Create')
                <li class="active"><a href="#available" aria-controls="available" role="tab" data-toggle="tab">Available</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Posisi Iklan Item Task-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Posisi Iklan Item Task-Create')
                <div role="tabpanel" class="tab-pane active" id="available">
                   <div class="table-responsive">
                        <table id="grid-data-available" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="posisi_iklan_item_name" data-order="asc">Title</th>
                                    <th data-column-id="summary_item_period_start" data-order="asc">Show Date</th>
                                    <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>                 
                </div>
                <div role="tabpanel" class="tab-pane" id="onprocess">
                    <div class="table-responsive">
                        <table id="grid-data-onprocess" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="posisi_iklan_item_name" data-order="asc">Title</th>
                                    <th data-column-id="summary_item_period_start" data-order="asc">Show Date</th>
                                    <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
                @can('Posisi Iklan Item Task-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="media_name" data-order="asc">Media</th>
                                    <th data-column-id="client_name" data-order="asc">Client</th>
                                    <th data-column-id="posisi_iklan_item_name" data-order="asc">Title</th>
                                    <th data-column-id="summary_item_period_start" data-order="asc">Show Date</th>
                                    <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
            </div>
        </div>
        </div>
    </div>
</div>    
@endsection

@section('customjs')
<script type="text/javascript">
var uid = '{{ Request::user()->user_id }}';
</script>
<script src="{{ url('js/workorder/posisiiklanitemtask.js') }}"></script>
@endsection