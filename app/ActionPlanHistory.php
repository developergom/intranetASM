<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionPlanHistory extends Model
{
    protected $table = 'action_plan_histories';
	protected $primaryKey = 'action_plan_history_id';

	protected $fillable = [
				'action_plan_id', 
				'action_plan_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function action_plan() 
	{
		return $this->belongsTo('App\ActionPlan', 'action_plan_history_id');
	}
}
