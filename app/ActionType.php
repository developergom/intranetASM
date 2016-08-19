<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionType extends Model
{
    protected $table = 'action_types';
	protected $primaryKey = 'action_type_id';

	protected $fillable = [
				'action_type_name', 'action_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function actionplan() {
		return $this->hasMany('App\ActionPlan', 'action_plan_id');
	}
}
