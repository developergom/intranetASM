@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Posisi Iklan<small>List of all posisi iklan</small></h2>
        @can('Posisi Iklan-Create')
        <a href="{{ url('workorder/posisi_iklan/create') }}" title="Create New Posisi Iklan"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
        @endcan
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="updated_at" data-order="desc">Last Updated</th>
                    <th data-column-id="posisi_iklan_code" data-order="asc">Code</th>
                    <th data-column-id="media_name" data-order="asc">Media</th>
                    <th data-column-id="posisi_iklan_type" data-order="asc">Type</th>
                    @can('Posisi Iklan-Update')
                        @can('Posisi Iklan-Delete')
                            <th data-column-id="link" data-formatter="link-rud" data-sortable="false">Action</th>
                        @else
                            <th data-column-id="link" data-formatter="link-ru" data-sortable="false">Action</th>
                        @endcan
                    @else
                        @can('Posisi Iklan-Delete')
                            <th data-column-id="link" data-formatter="link-rd" data-sortable="false">Action</th>
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
@endsection

@section('customjs')
<script src="{{ url('js/workorder/posisiiklan.js') }}"></script>
@endsection