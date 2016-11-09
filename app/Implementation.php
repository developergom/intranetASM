<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Implementation extends Model
{
    protected $table = 'implementations';
	protected $primaryKey = 'implementation_id';

	protected $fillable = [
				'implementation_month', 'implementation_month_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function eventplans()
    {
    	return $this->belongsToMany('App\EventPlan','action_plans_implementations');
    }

    public function inventoriesplanner()
    {
    	return $this->belongsToMany('App\InventoryPlanner', 'inventory_planner_implementation');
    }
}
