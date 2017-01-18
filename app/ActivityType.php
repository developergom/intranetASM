<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    protected $table = 'activity_types';
	protected $primaryKey = 'activity_type_id';

	protected $fillable = [
				'activity_type_name', 'activity_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function activities() {
		return $this->hasMany('App\Activity', 'activity_type_id');
	}
}
