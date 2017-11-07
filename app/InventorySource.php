<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventorySource extends Model
{
    protected $table = 'inventory_sources';
	protected $primaryKey = 'inventory_source_id';

	protected $fillable = [
				'inventory_source_name', 'inventory_source_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoriesplanner()
	{
		return $this->hasMany('App\InventoryPlanner', 'inventory_planner_id');
	}
}
