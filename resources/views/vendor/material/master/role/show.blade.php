@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Role Management<small>View Role</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form">
	            <div class="form-group">
	                <label for="role_name" class="col-sm-2 control-label">Role Name</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <input type="text" class="form-control input-sm" name="role_name" id="role_name" placeholder="Role Name" required="true" maxlength="100" value="{{ $role->role_name }}" disabled="true">
	                    </div>
	                </div>
	            </div>
	            <div class="form-group">
	                <label for="role_desc" class="col-sm-2 control-label">Description</label>
	                <div class="col-sm-10">
	                    <div class="fg-line">
	                        <textarea class="form-control input-sm" name="role_desc" id="role_desc" placeholder="Description" disabled="true">{{ $role->role_desc }}</textarea>
	                    </div>
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
					            								<input name="module_id[{{ $menu['module_id'] }}][{{ $action->action_id }}]" type="checkbox" class="checkbox-item-{{ $menu['module_id'] }}" data-parent="{{ $menu['menu_parent'] }}" data-module="{{ $menu['module_id'] }}" value="1" checked="true" disabled="true">
					            							@else
					            								<input name="module_id[{{ $menu['module_id'] }}][{{ $action->action_id }}]" type="checkbox" class="checkbox-item-{{ $menu['module_id'] }}" data-parent="{{ $menu['menu_parent'] }}" data-module="{{ $menu['module_id'] }}" value="1" disabled="true">
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
	                    <a href="{{ url('master/role') }}" class="btn btn-danger btn-sm">Back</a>
	                </div>
	            </div>
	        </form>
        </div>
    </div>
@endsection