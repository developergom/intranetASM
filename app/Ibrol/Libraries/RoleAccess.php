<?php

namespace App\Ibrol\Libraries;

use DB;
use Cache;
use App\User;

class RoleAccess{
	public static function hasAccess($roles, $module_id, $action_id) {
    	$access = false;

        if(!Cache::has('roles_modules')) {
            $tmp = DB::table('roles_modules')->get();

            $data = array();

            foreach ($tmp as $key => $value) {
                $data[$key]['role_id'] = $value->role_id;
                $data[$key]['module_id'] = $value->module_id;
                $data[$key]['action_id'] = $value->action_id;
                $data[$key]['access'] = $value->access;
            }

            $collection = collect($tmp);

            Cache::add('roles_modules', $collection, 60);
        }

    	foreach($roles as $role) {
            $roles_modules = Cache::get('roles_modules');
            if($roles_modules->where('role_id', $role->role_id)->where('module_id', $module_id)->where('action_id', $action_id)->count() > 0) {
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