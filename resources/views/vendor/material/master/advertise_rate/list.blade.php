@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Advertise Rates Management<small>List of all advertise rates</small></h2>
        <a href="{{ url('master/advertiserate/create') }}" title="Create New Advertise Rate"><button class="btn bgm-blue btn-float waves-effect"><i class="zmdi zmdi-plus"></i></button></a>
    </div>

    <div class="table-responsive">
        <table id="grid-data" class="table table-striped">
            <thead>
                <tr>
                    <th data-column-id="media_name" data-order="asc">Media</th>
                    <th data-column-id="advertise_position_name" data-order="asc">Position</th>
                    <th data-column-id="advertise_size_name" data-order="asc">Size</th>
                    <th data-column-id="advertise_rate_code" data-order="asc">Code</th>
                    <th data-column-id="advertise_rate_normal" data-converter="price" data-order="asc">Normal Rate</th>
                    <th data-column-id="advertise_rate_discount" data-converter="price" data-order="asc">Discount Rate</th>
                    <th data-column-id="link" data-formatter="link" data-sortable="false">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>    
@endsection

@section('vendorjs')
<script src="{{ url('js/jquery.price_format.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/advertiserate.js') }}"></script>
@endsection