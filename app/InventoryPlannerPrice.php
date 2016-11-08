<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryPlannerPrice extends Model
{
    protected $table = 'inventory_planner_prices';
	protected $primaryKey = 'inventory_planner_price_id';

	protected $fillable = [
				'inventory_planner_id', 
				'price_type_id', 
				'media_id',
				'media_edition_id',
				'advertise_rate_id',
				'inventory_planner_price_startdate',
				'inventory_planner_price_enddate',
				'inventory_planner_price_deadline',
				'inventory_planner_price_remarks',
				'inventory_planner_price_gross_rate',
				'inventory_planner_price_surcharge',
				'inventory_planner_price_total_gross_rate',
				'inventory_planner_price_discount',
				'inventory_planner_price_nett_rate',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoryplanner()
	{
		return $this->belongsTo('App\InventoryPlanner', 'inventory_planner_id');
	}

	public function pricetype()
	{
		return $this->belongsTo('App\PriceType', 'price_type_id');
	}

	public function media()
	{
		return $this->belongsTo('App\Media', 'media_id');
	}

	public function mediaedition()
	{
		return $this->belongsTo('App\MediaEdition', 'media_edition_id');
	}

	public function advertiserate()
	{
		return $this->belongsTo('App\AdvertiseRate', 'advertise_rate_id');
	}
}
