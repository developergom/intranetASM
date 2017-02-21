<?php

namespace App\Ibrol\Libraries;

use DB;
use Cache;
use App\User;

class RoleAccess{
	public static function hasAccess($roles, $module_id, $action_id) {
    	$access = false;

    	foreach($roles as $role) {
            if(DB::table('roles_modules')->select('access')->where('role_id', $role->role_id)->where('module_id', $module_id)->where('action_id', $action_id)->count() > 0) {
                $access = true;
            }
    	}

    	return $access;
    }

    public function checkAccess($role_id, $module_id, $action_id) {
    	if(DB::table('roles_modules')->where('role_id', $role_id)->where('module_id', $module_id)->where('action_id', $action_id)->count() > 0) {
    		return true;
    	}else{
    		return false;
    	}
    }
}