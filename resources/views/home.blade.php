@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/announcement-home.css') }}" rel="stylesheet">
<link href="{{ url('css/monthly.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/pygment_trac.css') }}" rel="stylesheet">
<link href="{{ url('css/jquery.easy-pie-chart.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if(count($announcements) > 0)
    <div id="announcement-container" class="alert alert-info" role="alert">
        <div id="text">
            @foreach($announcements as $announcement)
                {!! $announcement->announcement_detail . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="zmdi zmdi-info"></span>&nbsp;&nbsp;&nbsp;&nbsp;' !!}
            @endforeach
        </div>
    </div>
    @endif
	<div class="block-header">
        <h2>Dashboard</h2>
        <ul class="actions">
        <li>
            <div class="fg-line">
                <select class="form-control input-sm" id="dashboard-month">
                    <option value="01" {{ ($month=='01') ? 'selected' : '' }}>January</option>
                    <option value="02" {{ ($month=='02') ? 'selected' : '' }}>February</option>
                    <option value="03" {{ ($month=='03') ? 'selected' : '' }}>March</option>
                    <option value="04" {{ ($month=='04') ? 'selected' : '' }}>April</option>
                    <option value="05" {{ ($month=='05') ? 'selected' : '' }}>May</option>
                    <option value="06" {{ ($month=='06') ? 'selected' : '' }}>June</option>
                    <option value="07" {{ ($month=='07') ? 'selected' : '' }}>July</option>
                    <option value="08" {{ ($month=='08') ? 'selected' : '' }}>August</option>
                    <option value="09" {{ ($month=='09') ? 'selected' : '' }}>September</option>
                    <option value="10" {{ ($month=='10') ? 'selected' : '' }}>October</option>
                    <option value="11" {{ ($month=='11') ? 'selected' : '' }}>November</option>
                    <option value="12" {{ ($month=='12') ? 'selected' : '' }}>December</option>
                </select>
            </div>
        </li>
        <li>
            <div class="fg-line">
                <select class="form-control input-sm" id="dashboard-year">
                    @foreach($years as $year)
                    <option value="{{ $year }}" {{ ($year==$thisyear) ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
        </li>
    </ul>
    </div>

    @can('Proposal-Read')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-blue">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Proposals Created</small>
                        <h2 title="Proposals Created" id="dashboard_proposal_created" data-statistics-type="proposals_created" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-orange">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Direct Proposals</small>
                        <h2 title="Direct Proposals" id="dashboard_proposal_direct" data-statistics-type="direct_proposals" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-gray">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Brief Proposals</small>
                        <h2 title="Brief Proposals" id="dashboard_proposal_brief" data-statistics-type="brief_proposals" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-lightgreen">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Sold Proposals</small>
                        <h2 title="Sold Proposals" id="dashboard_proposal_sold" data-statistics-type="sold_proposals" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @can('Inventory Planner-Read')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-blue">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Inventories Created</small>
                        <h2 title="Inventories Created" id="dashboard_inventories_created" data-statistics-type="inventories_created" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-orange">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Inventories Linked with Proposal</small>
                        <h2 title="Inventories Linked with Proposal" id="dashboard_inventories_linked" data-statistics-type="inventories_linked_with_proposal" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-red">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Inventories Not Sold</small>
                        <h2 title="Inventories Not Sold" id="dashboard_inventories_not_sold" data-statistics-type="inventories_not_sold" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-lightgreen">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Inventories Sold</small>
                        <h2 title="Inventories Sold" id="dashboard_inventories_sold" data-statistics-type="inventories_sold" class="modal-statistics-trigger" data-toggle="modal" data-target="#modal-statistics-detail">0</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
    
    <div class="row">
        @can('Agenda-Read')
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header"><h4>My Agenda</h4></div>
                <div class="card-body card-padding">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="my-agenda-select-author" class="col-sm-2 control-label">Author</label>
                            <div class="col-sm-7">
                                <div class="fg-line">
                                    <select name="my-agenda-select-author[]" id="my-agenda-select-author" class="selectpicker" data-live-search="true" multiple>
                                        <option value="{{ $my_agenda_current->user_id }}" selected>{{ $my_agenda_current->user_firstname . ' ' . $my_agenda_current->user_lastname }}</option>
                                        @foreach($my_agenda_subordinate as $row)
                                            <option value="{{ $row->user_id }}">{{ $row->user_firstname . ' ' . $row->user_lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-primary waves-effect" id="btn-my-agenda-process">Process</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="my-agenda-client-id" class="col-sm-2 control-label">Client</label>
                            <div class="col-sm-7">
                                <div class="fg-line">
                                    <select name="my-agenda-client-id" id="my-agenda-client-id" class="selectpicker" data-live-search="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                &nbsp;
                            </div>
                        </div>
                    </form>
                    <div id="my-agenda" class="monthly monthly-agenda-calendar" ></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            @can('Clients Management-Create')
            <div class="card">
                <div class="card-header">
                    <h2>Contacts Recap</h2>
                </div>

                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5" id="dashboard_contact_created">New Contact Created : 0</div>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5" id="dashboard_contact_updated">Contact Updated : 0</div>

                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            @endcan               
            <div class="card">
                <div class="card-header">
                    <h2>Agenda Recap</h2>
                </div>

                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5" id="dashboard_agenda_created">Total Created : 0</div>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5" id="dashboard_agenda_reported">Total Reported : 0</div>

                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">0</span>
                                </div>
                            </div>
                        </div>
                        <div id="agenda_recap_details">
                        
                        </div>
                    </div>
                </div>
            </div>
            @can('TBC Item List-Read')
            <div class="mini-charts-item bgm-bluegray">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>To Be Confirmed Summary Items</small>
                        <h2 title="TBC Items" id="dashboard_summary_item_tbc">{{ $summary_item_tbc }}</h2><a href="{{ url('workorder/tbc_item_list') }}"><span class="badge bgm-bluegray">View Details</span></a>
                    </div>
                </div>
            </div>
            @endcan
        </div>
        @endcan
    </div>

    <div class="row">
        @can('Inventory Planner-Read')
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header"><h4>Last Updated Inventories Planner</h4></div>
                <div class="card-body card-padding">
                    <div role="tabpanel" class="tab">
                        <ul class="tab-nav" role="tablist">
                            <li class="active"><a href="#lastUpdatedInventoriesPlanner" aria-controls="lastUpdatedInventoriesPlanner" role="tab" data-toggle="tab" aria-expanded="true">Inventories Planner</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane animated flipInX active" id="lastUpdatedInventoriesPlanner">
                                <div class="listview" id="list-lastUpdatedInventoriesPlanner"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>

    @can('Users Management-Read')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2>Server Storage</h2>
                </div>

                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5" id="dashboard_file_size">Total Uploaded Files Size : {{ $file_size }} MB</div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">{{ $file_size }} MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5" id="dashboard_file_total">Total Files : {{ $file_total }} items</div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">{{ $file_total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <div class="modal fade" id="modal-statistics-detail" tabindex="-1" role="dialog" aria-labelledby="modal-statistics-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal-statistics-detail-title">Modal title</h4>
                </div>
                <div class="modal-body" id="modal-statistics-detail-body">
                    <table class="table table-bordered table-hover" id="table-statistics-detail">
                        <thead>
                            <tr>
                                <th><center>Title</center></th>
                                <th><center>Author</center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer" id="modal-statistics-detail-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jquery.marquee.min.js') }}"></script>
<script src="{{ url('js/jquery.sparkline.min.js') }}"></script>
<script src="{{ url('js/jquery.easypiechart.min.js') }}"></script>
<script src="{{ url('js/monthly.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/app/home-modal-statistics.js') }}"></script>
@can('Agenda-Read')
<script src="{{ url('js/app/home-my-agenda.js') }}"></script>
@endcan
<script type="text/javascript">
var myToken = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function(){
    $('#text').marquee({
        duration: 20000,
        startVisible: true,
        duplicated: true
      });

    @can('Inventory Planner-Read')
    $.ajax({
        url: base_url + 'inventory/inventoryplanner/api/apiLoadLastUpdated/5',
        type: 'GET',
        dataType: 'json',
        error: function(){
            console.log('Error loading data');
        },
        success:function(data) {
            $.each(data, function(key, value){
                var ls = '';
                ls += '<a class="lv-item" href="' + base_url + 'inventory/inventoryplanner/' + value.inventory_planner_id + '"><div class="media"><div class="media-body"><div class="lv-title">' + value.inventory_planner_title + '</div><small class="lv-small">Created by : ' + value.created_by.user_firstname + ' ' + value.created_by.user_lastname + '</small></div></div></a>';
                $('#list-lastUpdatedInventoriesPlanner').append(ls);
            });
        }
    });
    @endcan

    proposalRecap($('#dashboard-month').val(), $('#dashboard-year').val());
    inventoryRecap($('#dashboard-month').val(), $('#dashboard-year').val());
    agendaRecap($('#dashboard-month').val(), $('#dashboard-year').val());
    contactRecap($('#dashboard-month').val(), $('#dashboard-year').val());

    $('#dashboard-month, #dashboard-year').change(function(){
        var month = $('#dashboard-month').val();
        var year = $('#dashboard-year').val();

        proposalRecap(month, year);
        inventoryRecap(month, year);
        agendaRecap(month, year);
        contactRecap(month, year);
    });

    @can('Summary-Create')
        $('.main-pie').easyPieChart();
    @endcan
});

function proposalRecap(month, year) {
    @can('Proposal-Read')
    $.ajax({
        url: base_url + 'api/proposalRecap',
        type: 'POST',
        data: {
            'month' : month,
            'year' : year,
            _token: myToken
        },
        dataType: 'json',
        error: function(){
            console.log('Error loading data');
        },
        success:function(data) {
            $('#dashboard_proposal_created').empty().append(data.proposal_created);
            $('#dashboard_proposal_direct').empty().append(data.proposal_direct);
            $('#dashboard_proposal_brief').empty().append(data.proposal_brief);
            $('#dashboard_proposal_sold').empty().append(data.proposal_sold);
        }
    });
    @endcan
}

function inventoryRecap(month, year) {
    @can('Inventory Planner-Read')
    $.ajax({
        url: base_url + 'api/inventoryRecap',
        type: 'POST',
        data: {
            'month' : month,
            'year' : year,
            _token: myToken
        },
        dataType: 'json',
        error: function(){
            console.log('Error loading data');
        },
        success:function(data) {
            $('#dashboard_inventories_created').empty().append(data.inventories_created);
            $('#dashboard_inventories_linked').empty().append(data.inventories_linked);
            $('#dashboard_inventories_not_sold').empty().append(data.inventories_not_sold);
            $('#dashboard_inventories_sold').empty().append(data.inventories_sold);
        }
    });
    @endcan
}

function agendaRecap(month, year) {
    @can('Agenda Plan-Read')
    $.ajax({
        url: base_url + 'api/agendaRecap',
        type: 'POST',
        data: {
            'month' : month,
            'year' : year,
            _token: myToken
        },
        dataType: 'json',
        error: function(e){
            console.log('Error loading data');
        },
        success:function(data) {
            $('#dashboard_agenda_created').empty().append("Total Created : " + data.agenda_total_created);
            $('#dashboard_agenda_reported').empty().append("Total Reported : " + data.agenda_total_reported);
            if(data.agenda_details.length > 0)
            {
                var html = '';
                $.each(data.agenda_details, function(key, value){
                    if(value.agenda_type_name!==null)
                    {
                        html += '<div class="list-group-item">';
                            html += '<div class="lgi-heading m-b-5">' + value.agenda_type_name + ' : ' + value.total + '</div>';
                                html += '<div class="progress">';
                                    html += '<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">';
                                    html += '<span class="sr-only"></span>';
                                html += '</div>';
                            html += '</div>';
                        html += '</div>';
                    }
                });

                $('#agenda_recap_details').empty().append(html);
            }
            
        }
    });
    @endcan
}

function contactRecap(month, year) {
    @can('Clients Management-Create')
    $.ajax({
        url: base_url + 'api/contactRecap',
        type: 'POST',
        data: {
            'month' : month,
            'year' : year,
            _token: myToken
        },
        dataType: 'json',
        error: function(e){
            console.log('Error loading data');
        },
        success:function(data) {
            $('#dashboard_contact_created').empty().append("New Contact Created : " + data.contact_created);
            $('#dashboard_contact_updated').empty().append("Contact Updated : " + data.contact_updated);
        }
    });
    @endcan
}
</script>
@endsection