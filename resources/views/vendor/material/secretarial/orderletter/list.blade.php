@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Order Letter<small>List of all order letters</small></h2>
        @can('Order Letter-Create')
        <a href="{{ url('secretarial/orderletter/create') }}" title="Create New Order"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Order Letter-Approval')
                <li class="active"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Order Letter-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
                @can('Order Letter-Create')
                <li><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Order Letter-Approval')
                <div role="tabpanel" class="tab-pane active" id="needchecking">
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="letter_type_name" data-order="asc">Letter Type</th>
                                    <th data-column-id="letter_to" data-order="asc">Letter To</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Order Letter-Update')
                                        @can('Order Letter-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Order Letter-Approval')
                                            <th data-column-id="link" data-formatter="link-ra" data-sortable="false">Action</th>
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
                <div role="tabpanel" class="tab-pane" id="onprocess">
                    <div class="table-responsive">
                        <table id="grid-data-onprocess" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="letter_type_name" data-order="asc">Letter Type</th>
                                    <th data-column-id="letter_to" data-order="asc">Letter To</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Order Letter-Delete')
                                        <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
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
                @endcan
                @can('Order Letter-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="letter_type_name" data-order="asc">Letter Type</th>
                                    <th data-column-id="letter_to" data-order="asc">Letter To</th>
                                    <th data-column-id="letter_no" data-order="asc">Letter No</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
                @can('Order Letter-Create')
                <div role="tabpanel" class="tab-pane" id="canceled">
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="letter_type_name" data-order="asc">Letter Type</th>
                                    <th data-column-id="letter_to" data-order="asc">Letter To</th>
                                    <th data-column-id="letter_no" data-order="asc">Letter No</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
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
<script src="{{ url('js/secretarial/orderletter.js') }}"></script>
@endsection