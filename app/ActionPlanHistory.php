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

	public function actionplan() 
	{
		return $this->belongsTo('App\ActionPlan', 'action_plan_id');
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		//return $user->user_firstname . ' ' . $user->user_lastname;
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 
		//return $user->user_firstname . ' ' . $user->user_lastname;
		return $user;
	}
}
