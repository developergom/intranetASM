@extends('vendor.material.layouts.app')

@section('vendorcss')
<link href="{{ url('css/bootstrap-select.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card">
        <div class="card-header"><h2>Role Management<small>Edit Role</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/role/'.$role->role_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
        		<div class="form-group">
	                <label for="role_level_id" class="col-sm-2 control-label">Role Level</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <select name="role_level_id" id="role_level_id" class="selectpicker" data-live-search="true" required="true">
	                        	<option value=""></option>
                                @foreach ($rolelevels as $row)
                                	{!! $selected = '' !!}
                                	@if($row->role_level_id==$role->role_level_id)
                                		{!! $selected = 'selected' !!}
                                	@endif
								    <option value="{{ $row->role_level_id }}" {{ $selected }}>{{ $row->role_level_name }}</option>
								@endforeach
                            </select>
	                    </div>
	                    @if ($errors->has('role_level_id'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('role_level_id') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_name" class="col-sm-2 control-label">Role Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="role_name" id="role_name" placeholder="Role Name" required="true" maxlength="100" value="{{ $role->role_name }}">
	                    </div>
	                    @if ($errors->has('role_name'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('role_name') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea class="form-control input-sm" name="role_desc" id="role_desc" placeholder="Description">{{ $role->role_desc }}</textarea>
	                    </div>
	                    @if ($errors->has('role_desc'))
			                <span class="help-block">
			                    <strong>{{ $errors->first('role_desc') }}</strong>
			                </span>
			            @endif
	                </div>
	            </div>
	            <div class="form-group">
	            	<div class="col-sm-12">
	            		<table class="table table-bordered table-hover">
	            			<thead>
	            				<tr>
	            					<th>Menu Name</th>
	            					@foreach($actions as $action)
	            						<th><center>{{ $action->action_name }}</center></th>
	            					@endforeach
	            				</tr>
	            			</thead>
	            			<tbody>
	            			@foreach($menus as $menu)
	            				<tr>
	            					<td>
	            						<div class="checkbox m-b-15">
    										<label>
    											<input name="module_id[{{ $menu['module_id'] }}]" type="checkbox" class="checkbox-check-all" data-parent="{{ $menu['menu_parent'] }}" data-module="{{ $menu['module_id'] }}" value="{{ $menu['module_id'] }}">
    											<i class="input-helper"></i>
    											{{ $menu['menu_name'] }}
    										</label>
    									</div>
	            					</td>
	            					@foreach($actions as $action)
	            						@if(in_array($action->action_id, $menu['action']))
	            							<td>
	            								<center>
	            									<div class="checkbox m-b-15">
	            										<label>
	            											@if(count($rolesmodules->where('module_id', $menu['module_id'])->where('action_id', $action->action_id)) > 0)
					            								<input name="module_id[{{ $menu['module_id'] }}][{{ $action->action_id }}]" type="checkbox" class="checkbox-item-{{ $menu['module_id'] }}" data-parent="{{ $menu['menu_parent'] }}" data-module="{{ $menu['module_id'] }}" value="1" checked="true">
					            							@else
					            								<input name="module_id[{{ $menu['module_id'] }}][{{ $action->action_id }}]" type="checkbox" class="checkbox-item-{{ $menu['module_id'] }}" data-parent="{{ $menu['menu_parent'] }}" data-module="{{ $menu['module_id'] }}" value="1">
					            							@endif
	            											<i class="input-helper"></i>
	            										</label>
	            									</div>
	            								</center>
	            							</td>
	            						@else
	            							<td>&nbsp;</td>
	            						@endif
	            					@endforeach
	            				</tr>
	            			@endforeach
	            			</tbody>
	            		</table>
	            	</div>
	            </div>
	            <div class="form-group">
	                <div class="col-sm-offset-2 col-sm-10">
	                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
	                    <a href="{{ url('master/role') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection

@section('vendorjs')
<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
@endsection

@section('customjs')
<script src="{{ url('js/master/role-create.js') }}"></script>
@endsection