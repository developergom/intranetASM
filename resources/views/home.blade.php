@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/announcement-home.css') }}" rel="stylesheet">
<link href="{{ url('css/monthly.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
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
    </div>

    @can('Proposal-Read')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="mini-charts-item bgm-blue">
                <div class="clearfix">
                    <div class="chart stats-bar"><canvas width="68" height="35" style="display: inline-block; width: 68px; height: 35px; vertical-align: top;"></canvas></div>
                    <div class="count">
                        <small>Proposals Created</small>
                        <h2 title="Proposals Created">{{ number_format($proposal_created) }}</h2>
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
                        <h2 title="Direct Proposals">{{ number_format($proposal_direct) }}</h2>
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
                        <h2 title="Brief Proposals">{{ number_format($proposal_brief) }}</h2>
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
                        <h2 title="Sold Proposals">{{ number_format($proposal_sold) }}</h2>
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
                        <h2 title="Inventories Created">{{ number_format($inventories_created) }}</h2>
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
                        <h2 title="Inventories Linked with Proposal">{{ number_format($inventories_linked) }}</h2>
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
                        <h2 title="Inventories Not Sold">{{ number_format($inventories_not_sold) }}</h2>
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
                        <h2 title="Inventories Sold">{{ number_format($inventories_sold) }}</h2>
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
            <div class="card">
                <div class="card-header">
                    <h2>Agenda Recap</h2>
                </div>

                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5">Total Created : {{ $agenda_total_created }}</div>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">{{ $agenda_total_created }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5">Total Reported : {{ $agenda_total_reported }}</div>

                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $agenda_total_reported/$agenda_total_created*100 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $agenda_total_reported/$agenda_total_created*100 }}%">
                                    <span class="sr-only">{{ $agenda_total_reported }}</span>
                                </div>
                            </div>
                        </div>
                        @foreach($agenda_details as $agenda)
                        <div class="list-group-item">
                            <div class="lgi-heading m-b-5">{{ $agenda->agenda_type_name }} : {{ $agenda->total }}</div>

                            <div class="progress">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{ $agenda->total/$agenda_total_created*100 }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $agenda->total/$agenda_total_created*100 }}%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
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
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/jquery.marquee.min.js') }}"></script>
<script src="{{ url('js/jquery.sparkline.min.js') }}"></script>
<script src="{{ url('js/monthly.js') }}"></script>
@endsection

@section('customjs')
@can('Agenda-Read')
<script src="{{ url('js/app/home-my-agenda.js') }}"></script>
@endcan
<script type="text/javascript">
$(document).ready(function(){
    $('#text').marquee({
        duration: 60000,
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

    @can('Proposal-Read')
    @endcan

});
</script>
@endsection