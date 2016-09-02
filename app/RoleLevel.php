<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleLevel extends Model
{
    protected $table = 'role_levels';
	protected $primaryKey = 'role_level_id';

	protected $fillable = [
				'role_level_name', 'role_level_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function roles() {
        return $this->hasMany('App\Role','role_level_id');
    }
}
