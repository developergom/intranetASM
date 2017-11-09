<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellPeriod extends Model
{
    protected $table = 'sell_periods';
	protected $primaryKey = 'sell_period_id';

	protected $fillable = [
				'sell_period_month', 'sell_period_month_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function inventoriesplanner()
    {
    	return $this->belongsToMany('App\InventoryPlanner', 'inventory_planner_sell_period')->withPivot('year');;
    }
}
