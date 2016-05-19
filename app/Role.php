<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{
	protected $table = 'roles';
	protected $primaryKey = 'role_id';

	protected $fillable = [
				'role_name', 'role_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function users() {
        return $this->belongsToMany('App\User','users_roles');
    }
}