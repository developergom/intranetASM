@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Religion Management<small>List of all religions</small></h2>
        <a href="{{ url('master/religion/create') }}" title="Create New Religion"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-hover">
            <thead>
                <tr>
                    <th data-column-id="religion_name" data-order="asc">Religion Name</th>
                    <th data-column-id="link" data-formatter="link" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/master/religion.js') }}"></script>
@endsection