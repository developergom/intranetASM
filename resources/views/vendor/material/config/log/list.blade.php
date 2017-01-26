@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>User Logs<small>List of user logs</small></h2>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="user_name" data-order="asc">NIK</th>
                    <th data-column-id="user_firstname" data-order="asc">Firstname</th>
                    <th data-column-id="user_lastname" data-order="asc">Lastname</th>
                    <th data-column-id="log_ip" data-order="asc">IP Address</th>
                    <th data-column-id="log_device" data-order="asc">Device</th>
                    <th data-column-id="log_url" data-order="asc">URL</th>
                    <th data-column-id="log_os" data-order="asc">OS</th>
                    <th data-column-id="log_browser" data-order="asc">Browser</th>
                    <th data-column-id="access_time" data-order="asc">Access Time</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/config/log.js') }}"></script>
@endsection