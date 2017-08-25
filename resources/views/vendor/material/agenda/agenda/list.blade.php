@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Agenda Plan<small>List of all Agenda Plans</small></h2>
        @can('Agenda Plan-Create')
        <a href="{{ url('agenda/plan/create') }}" title="Create New Agenda"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div role="tabpanel">
        <ul class="tab-nav" role="tablist">
            <li class="active"><a href="#unreported" aria-controls="unreported" role="tab" data-toggle="tab">Unreported</a></li>
            <li><a href="#reported" aria-controls="reported" role="tab" data-toggle="tab">Reported</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="unreported">
                <div class="table-responsive">
                    <table id="grid-data-unreported" class="table table-hover">
                        <thead>
                            <tr>
                                <th data-column-id="agenda_date" data-converter="datetime" data-order="asc"><center>Date</center></th>
                                <th data-column-id="agenda_type_name" data-order="asc"><center>Type</center></th>
                                <th data-column-id="agenda_is_report" data-formatter="agenda-status"><center>Status</center></th>
                                <!-- <th data-column-id="agenda_destination" data-order="asc">Destination</th> -->
                                <th data-column-id="user_firstname" data-order="asc"><center>Author</center></th>
                                @can('Agenda Plan-Update')
                                    @can('Agenda Plan-Delete')
                                        <th data-column-id="link" data-formatter="link-rud" data-sortable="false"><center>Action</center></th>
                                    @else
                                        <th data-column-id="link" data-formatter="link-ru" data-sortable="false"><center>Action</center></th>
                                    @endcan
                                @else
                                    @can('Agenda Plan-Delete')
                                        <th data-column-id="link" data-formatter="link-rd" data-sortable="false"><center>Action</center></th>
                                    @else
                                        <th data-column-id="link" data-formatter="link-r" data-sortable="false"><center>Action</center></th>
                                    @endcan
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="reported">
                <div class="table-responsive">
                    <table id="grid-data-reported" class="table table-hover">
                        <thead>
                            <tr>
                                <th data-column-id="agenda_date" data-converter="datetime" data-order="asc"><center>Date</center></th>
                                <th data-column-id="agenda_type_name" data-order="asc"><center>Type</center></th>
                                <th data-column-id="agenda_is_report" data-formatter="agenda-status"><center>Status</center></th>
                                <!-- <th data-column-id="agenda_destination" data-order="asc">Destination</th> -->
                                <th data-column-id="user_firstname" data-order="asc"><center>Author</center></th>
                                <th data-column-id="link" data-formatter="link-r" data-sortable="false"><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
<script src="{{ url('js/agenda/agenda.js') }}"></script>
@endsection