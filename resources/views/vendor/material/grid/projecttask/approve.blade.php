@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Project Task<small>Approve Project Task</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('grid/projecttask/approve/' . $projecttask->flow_no . '/' . $projecttask->project_task_id) }}">
        		{{ csrf_field() }}
        		@include('vendor.material.grid.projecttask.view')
	            <div class="form-group">
	                <label for="approval" class="col-sm-2 control-label">Approval</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <label class="radio radio-inline m-r-20">
	                            <input name="approval" value="1" type="radio" required>
	                            <i class="input-helper"></i>  
	                            Yes
	                        </label>
	                        <label class="radio radio-inline m-r-20">
	                            <input name="approval" value="0" type="radio" required>
	                            <i class="input-helper"></i>  
	                            No
	                        </label>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="pic" class="col-sm-2 control-label">PIC</label>
	            	<div class="col-sm-10">
	            		<select name="pic" id="pic" class="selectpicker" data-live-search="true" required="true">
        					<option value=""></option>
        					@foreach($subordinate as $row)
        						{!! $selected = '' !!}
                            	@if(old('pic')==$row->user_id)
                                	{!! $selected = 'selected' !!}
                            	@endif
        						<option value="{{ $row->user_id }}" {{ $selected }}>{{ $row->user_firstname . ' - ' . $row->user_lastname }}</option>
        					@endforeach
        				</select>
	            	</div>
	            </div>
	            <div class="form-group">
	                <label for="comment" class="col-sm-2 control-label">Comment</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea name="comment" id="comment" class="form-control input-sm" placeholder="Comment" required="true">{{ old('comment') }}</textarea>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('grid/projecttask') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection