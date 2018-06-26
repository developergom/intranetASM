<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryPlannerCostDetails extends Model
{
    //protected $table = 'inventory_planner_cost_details';
    protected $primaryKey = 'inventory_planner_cost_details_id';

	protected $fillable = [
				'inventory_planner_id', 
				'inventory_planner_cost',
				'inventory_planner_media_cost_print',
				'inventory_planner_media_cost_other',
				'inventory_planner_total_offering',
				'status',
				'revision_no',
	];

	/*
	public function inventoriesplanner()
	{
		return $this->belongsToMany('App\InventoryPlanner', 'inventory_planner_cost_details');
	} */
}
