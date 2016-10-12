<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPlanHistory extends Model
{
    protected $table = 'event_plan_histories';
	protected $primaryKey = 'event_plan_history_id';

	protected $fillable = [
				'event_plan_id', 
				'approval_type_id', 
				'event_plan_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function eventplan() 
	{
		return $this->belongsTo('App\EventPlan', 'event_plan_id');
	}

	public function approvaltype()
	{
		return $this->belongsTo('App\ApprovalType', 'approval_type_id');	
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 		
		return $user;
	}
}
