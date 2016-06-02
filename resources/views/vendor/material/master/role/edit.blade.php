@extends('vendor.material.layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h2>Role Management<small>Edit Role</small></h2></div>
        <div class="card-body card-padding">
        	<form class="form-horizontal" role="form" method="POST" action="{{ url('master/role/'.$role->role_id) }}">
        		{{ csrf_field() }}
        		<input type="hidden" name="_method" value="PUT">
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
	            		<table class="table table-bordered table-hover table-striped">
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
	            					<td>{{ $menu['menu_name'] }}</td>
	            					@foreach($actions as $action)
	            						@if(in_array($action->action_id, $menu['action']))
	            							<td>
	            								<center>
	            									<div class="checkbox m-b-15">
	            										<label>
	            											<input type="checkbox" value="{{ $action->action_id }}">
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