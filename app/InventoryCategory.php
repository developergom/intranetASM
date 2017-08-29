<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryCategory extends Model
{
    protected $table = 'inventory_categories';
	protected $primaryKey = 'inventory_category_id';

	protected $fillable = [
				'inventory_category_name', 'inventory_category_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoriesplanner()
	{
		return $this->belongsToMany('App\InventoryPlanner', 'inventory_category_inventory_planner');
	}
}
