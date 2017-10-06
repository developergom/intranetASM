<?php

namespace App\Ibrol\Libraries;

use App\User;

class UserLibrary{
	public function getUserSubordinate($user_id) {
		$user = User::find($user_id);

		$user_group = array();
		foreach ($user->groups as $key => $value) {
			array_push($user_group, $value['group_id']);
		}

		$role = 0;
		foreach ($user->roles as $key => $value) {
			if($role < $value['role_level_id'])
				$role = $value['role_level_id'];
		}

		$result = User::join('users_groups', 'users_groups.user_id', '=', 'users.user_id')
						->join('users_roles', 'users_roles.user_id', '=', 'users.user_id')
						->join('roles', 'roles.role_id', '=', 'users_roles.role_id')
						->whereIn('users_groups.group_id', $user_group)
						->where('roles.role_level_id', '<', $role)
						->where('users.user_id', '<>', $user_id)
						->where('users.active', '1')
						->get();

		return $result;
	}

	public function getSubOrdinateArrayID($user_id) {
		$tmp = $this->getUserSubordinate($user_id);

		$result = array();
		foreach ($tmp as $key => $value) {
			array_push($result, $value['user_id']);
		}

		return $result;
	}

	public function getMedias($user_id) {
		$result = [];

		$user = User::with('medias')->find($user_id);

		foreach($user->medias as $key => $value) {
			array_push($result, $value->media_id);
		}

		return $result;
	}
}