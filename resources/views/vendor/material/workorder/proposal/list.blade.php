@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Proposal<small>List of all proposal</small></h2>
        @can('Proposal-Create')
        <a href="{{ url('workorder/proposal/create') }}" title="Create New Proposal"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="card-body card-padding">
        <div role="tabpanel">
            <ul class="tab-nav" role="tablist">
                @can('Proposal-Approval')
                <li class="active"><a href="#needchecking" aria-controls="needchecking" role="tab" data-toggle="tab">Need Checking</a></li>
                <li><a href="#onprocess" aria-controls="onprocess" role="tab" data-toggle="tab">On Process</a></li>
                @endcan
                @can('Proposal-Read')
                <li><a href="#finished" aria-controls="finished" role="tab" data-toggle="tab">Finished</a></li>
                @endcan
                @can('Proposal-Create')
                <li><a href="#canceled" aria-controls="canceled" role="tab" data-toggle="tab">Canceled</a></li>
                @endcan
            </ul>
            <div class="tab-content">
                @can('Proposal-Approval')
                <div role="tabpanel" class="tab-pane active" id="needchecking">
                    <div class="row">
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Proposal Type</label>
                                <select id="need_checking_proposal_type_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL TYPES</option>
                                    @foreach($proposal_types as $row)
                                        {!! $selected = '' !!}
                                        @if(old('proposal_type_id')==$row->proposal_type_id)
                                            {!! $selected = 'selected' !!}
                                        @endif
                                        <option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Industry</label>
                                <select id="need_checking_industry_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL INDUSTRIES</option>
                                    @foreach ($industries as $row)
                                        {!! $selected = '' !!}
                                        @if(old('industry_id'))
                                            @foreach (old('industry_id') as $key => $value)
                                                @if($value==$row->industry_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Media</label>
                                <select id="need_checking_media_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL MEDIAS</option>
                                    @foreach ($medias as $row)
                                        {!! $selected = '' !!}
                                        @if(old('media_id'))
                                            @foreach (old('media_id') as $key => $value)
                                                @if($value==$row->media_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                   <div class="table-responsive">
                        <table id="grid-data-needchecking" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="proposal_name" data-order="asc">Title</th>
                                    <th data-column-id="proposal_deadline" data-order="asc">Deadline</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    @can('Proposal-Update')
                                        @can('Proposal-Approval')
                                            <th data-column-id="link" data-formatter="link-rua" data-sortable="false">Action</th>
                                        @else
                                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                                        @endcan
                                    @else
                                        @can('Proposal-Approval')
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
                    <div class="row">
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Proposal Type</label>
                                <select id="on_process_proposal_type_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL TYPES</option>
                                    @foreach($proposal_types as $row)
                                        {!! $selected = '' !!}
                                        @if(old('proposal_type_id')==$row->proposal_type_id)
                                            {!! $selected = 'selected' !!}
                                        @endif
                                        <option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Industry</label>
                                <select id="on_process_industry_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL INDUSTRIES</option>
                                    @foreach ($industries as $row)
                                        {!! $selected = '' !!}
                                        @if(old('industry_id'))
                                            @foreach (old('industry_id') as $key => $value)
                                                @if($value==$row->industry_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Media</label>
                                <select id="on_process_media_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL MEDIAS</option>
                                    @foreach ($medias as $row)
                                        {!! $selected = '' !!}
                                        @if(old('media_id'))
                                            @foreach (old('media_id') as $key => $value)
                                                @if($value==$row->media_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="grid-data-onprocess" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="proposal_name" data-order="asc">Title</th>
                                    <th data-column-id="proposal_deadline" data-order="asc">Deadline</th>
                                    <th data-column-id="user_firstname" data-order="asc">Current User</th>
                                    @can('Proposal-Delete')
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
                @can('Proposal-Read')
                <div role="tabpanel" class="tab-pane" id="finished">
                    <div class="row">
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Proposal Type</label>
                                <select id="finished_proposal_type_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL TYPES</option>
                                    @foreach($proposal_types as $row)
                                        {!! $selected = '' !!}
                                        @if(old('proposal_type_id')==$row->proposal_type_id)
                                            {!! $selected = 'selected' !!}
                                        @endif
                                        <option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Industry</label>
                                <select id="finished_industry_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL INDUSTRIES</option>
                                    @foreach ($industries as $row)
                                        {!! $selected = '' !!}
                                        @if(old('industry_id'))
                                            @foreach (old('industry_id') as $key => $value)
                                                @if($value==$row->industry_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Media</label>
                                <select id="finished_media_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL MEDIAS</option>
                                    @foreach ($medias as $row)
                                        {!! $selected = '' !!}
                                        @if(old('media_id'))
                                            @foreach (old('media_id') as $key => $value)
                                                @if($value==$row->media_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="grid-data-finished" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="proposal_name" data-order="asc">Title</th>
                                    <th data-column-id="proposal_no" data-order="asc">Proposal No</th>
                                    <th data-column-id="user_firstname" data-order="asc">Created By</th>
                                    <th data-column-id="proposal_status_name" data-order="asc">Status</th>
                                    <th data-column-id="link" data-formatter="link-r" data-sortable="false">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endcan
                @can('Proposal-Create')
                <div role="tabpanel" class="tab-pane" id="canceled">
                    <div class="row">
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Proposal Type</label>
                                <select id="canceled_proposal_type_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL TYPES</option>
                                    @foreach($proposal_types as $row)
                                        {!! $selected = '' !!}
                                        @if(old('proposal_type_id')==$row->proposal_type_id)
                                            {!! $selected = 'selected' !!}
                                        @endif
                                        <option value="{{ $row->proposal_type_id }}" {{ $selected }}>{{ $row->proposal_type_name . ' - ' . $row->proposal_type_duration . ' day'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Industry</label>
                                <select id="canceled_industry_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL INDUSTRIES</option>
                                    @foreach ($industries as $row)
                                        {!! $selected = '' !!}
                                        @if(old('industry_id'))
                                            @foreach (old('industry_id') as $key => $value)
                                                @if($value==$row->industry_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->industry_id }}" {{ $selected }}>{{ $row->industry_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 m-b-20">
                            <div class="form-group fg-line">
                                <label>Media</label>
                                <select id="canceled_media_id" class="selectpicker" data-live-search="true" required="true">
                                    <option value="">ALL MEDIAS</option>
                                    @foreach ($medias as $row)
                                        {!! $selected = '' !!}
                                        @if(old('media_id'))
                                            @foreach (old('media_id') as $key => $value)
                                                @if($value==$row->media_id)
                                                    {!! $selected = 'selected' !!}
                                                @endif
                                            @endforeach
                                        @endif
                                        <option value="{{ $row->media_id }}" {{ $selected }}>{{ $row->media_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="grid-data-canceled" class="table table-hover">
                            <thead>
                                <tr>
                                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                                    <th data-column-id="proposal_name" data-order="asc">Title</th>
                                    <th data-column-id="proposal_deadline" data-order="asc">Deadline</th>
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


@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript">
var uid = '{{ Request::user()->user_id }}';
</script>
<script src="{{ url('js/workorder/proposal.js') }}"></script>
@endsection