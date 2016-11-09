<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryPlannerHistory extends Model
{
    protected $table = 'inventory_planner_histories';
	protected $primaryKey = 'inventory_planner_history_id';

	protected $fillable = [
				'inventory_planner_id', 
				'approval_type_id', 
				'inventory_planner_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoryplanner() 
	{
		return $this->belongsTo('App\InventoryPlanner', 'inventory_planner_id');
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
