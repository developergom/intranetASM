@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/chosen.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/ajax-bootstrap-select.min.css') }}" rel="stylesheet">
<link href="{{ url('css/basic.min.css') }}" rel="stylesheet">
<link href="{{ url('css/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Proposal<small>Detail Proposal</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		@include('vendor.material.workorder.proposal.view')
			    <div class="form-group">
			        <div class="col-sm-offset-2 col-sm-10">
			            <a href="{{ url('workorder/proposal') }}" class="btn btn-danger btn-sm">Back</a>
			        </div>
			    </div>
			</form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/chosen.jquery.js') }}"></script>
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/ajax-bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/dropzone.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
@endsection