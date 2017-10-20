@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Direct Letter<small>View Direct Letter</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
        		@include('vendor.material.secretarial.directletter.view')
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <a href="{{ url('secretarial/directletter') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection