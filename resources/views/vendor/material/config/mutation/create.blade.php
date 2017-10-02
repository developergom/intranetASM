@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Mutations Management<small>Create a mutation</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="mutation_from" class="col-sm-2 control-label">From User</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                    	<select name="mutation_from" id="mutation_from" class="selectpicker" data-live-search="true" required="true">
	                        	@foreach($users as $user)
	                        		{!! $selected = '' !!}
	                        		@if($user->user_id==old('mutation_from'))
	                        			{!! $selected = 'selected' !!}
	                        		@endif
	                        		<option value="{{ $user->user_id }}" {{ $selected }}>{{ $user->user_firstname . ' ' . $user->user_lastname . ' - ' . $user->user_name }}</option>
	                        	@endforeach
	                        </select>
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	            	<label for="tasks" class="col-sm-2 control-label">Tasks</label>
	            	<div class="col-sm-10">
	            		<div role="tabpanel">
	            			<ul class="tab-nav" role="tablist">
	            				<li class="active">
	            					<a href="#tab-inventories" aria-controls="tab-inventories" role="tab" data-toggle="tab" aria-expanded="true">Inventories&nbsp;<span class="badge" id="total-inventories">0</span></a>
	            				</li>
	            				<li>
	            					<a href="#tab-proposals" aria-controls="tab-proposals" role="tab" data-toggle="tab" aria-expanded="true">Proposals&nbsp;<span class="badge" id="total-proposals">0</span></a>
	            				</li>
	            				<li>
	            					<a href="#tab-summaries" aria-controls="tab-summaries" role="tab" data-toggle="tab" aria-expanded="true">Summaries&nbsp;<span class="badge" id="total-summaries">0</span></a>
	            				</li>
	            			</ul>
	            			<div class="tab-content">
	            				<div role="tabpanel" class="tab-pane active" id="tab-inventories">
	            					<div class="table-responsive">
	            						<table class="table table-hover" id="table-inventories">
	            							<thead>
	            								<tr>
	            									<th>Inventory Title</th>
	            									<th>Assign To</th>
	            								</tr>
	            							</thead>
	            							<tbody></tbody>
	            						</table>
	            					</div>
	            				</div>
	            				<div role="tabpanel" class="tab-pane" id="tab-proposals">
	            					<div class="table-responsive">
	            						<table class="table table-hover" id="table-proposals">
	            							<thead>
	            								<tr>
	            									<th>Proposal Name</th>
	            									<th>Assign To</th>
	            								</tr>
	            							</thead>
	            							<tbody></tbody>
	            						</table>
	            					</div>
	            				</div>
	            				<div role="tabpanel" class="tab-pane" id="tab-summaries">
	            					<div class="table-responsive">
	            						<table class="table table-hover" id="table-summaries">
	            							<thead>
	            								<tr>
	            									<th>Summary Order No</th>
	            									<th>Assign To</th>
	            								</tr>
	            							</thead>
	            							<tbody></tbody>
	            						</table>
	            					</div>
	            				</div>
	            			</div>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	            	<label for="mutation_desc" class="col-sm-2 control-label">Description</label>
	            	<div class="col-sm-10">
	            		<div class="fg-line">
	            			<textarea name="mutation_desc" id="mutation_desc" class="form-control input-sm" placeholder="Description"></textarea>
	            		</div>
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                	<button type="button" id="btn-process" class="btn btn-primary btn-sm waves-effect">Process</button>
	                    <a href="{{ url('/config/mutation') }}" class="btn btn-danger btn-sm waves-effect">Back</a>
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12" id="result_container">
	            		
	            	</div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script src="{{ url('js/input-mask.min.js') }}"></script>
@endsection

@section('customjs')
<script type="text/javascript" src="{{ url('js/config/mutation-create.js') }}"></script>
@endsection