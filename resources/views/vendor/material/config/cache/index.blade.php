@extends('vendor.material.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Cache Management<small>Cache Management</small></h2>
    </div>
    <div class="card-body card-padding">
    	<div class="row">
    		<div class="col-sm-12">
    			<button class="btn btn-danger" id="clear-all-cache">Clear all cache</button>
    		</div>
    	</div>
    </div>
</div>    
@endsection

@section('customjs')
<script src="{{ url('js/config/cache-management.js') }}"></script>
@endsection