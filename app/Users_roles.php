<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users_roles extends Model{
	protected $table = 'users_roles';

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function users() {
		return $this->belongsTo('App\User', 'user_id');
	}

	public function roles() {
		return $this->hasOne('App\Role', 'role_id');
	}
}