<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    protected $table = 'event_types';
	protected $primaryKey = 'event_type_id';

	protected $fillable = [
				'event_type_name', 'event_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function actionplan() {
		return $this->hasMany('App\ActionPlan', 'event_plan_id');
	}
}
