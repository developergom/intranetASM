<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
	protected $primaryKey = 'group_id';

	protected $fillable = [
				'group_name', 'group_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function users() {
        return $this->belongsToMany('App\User','users_groups');
    }
}
