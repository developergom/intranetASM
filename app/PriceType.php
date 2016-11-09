<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{
    protected $table = 'price_types';
	protected $primaryKey = 'price_type_id';

	protected $fillable = [
				'price_type_name', 'price_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoryplannerprices()
	{
		return $this->hasMany('App\InventoryPlannerPrice', 'price_type_id');
	}
}
