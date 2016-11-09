<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryType extends Model
{
    protected $table = 'inventory_types';
	protected $primaryKey = 'inventory_type_id';

	protected $fillable = [
				'inventory_type_name', 'inventory_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoriesplanner()
	{
		return $this->hasMany('App\InventoryPlanner', 'inventory_type_id');
	}
}
