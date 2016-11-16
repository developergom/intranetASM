<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiseRate extends Model
{
    protected $table = 'advertise_rates';
	protected $primaryKey = 'advertise_rate_id';

	protected $fillable = [
				'media_id',
				'advertise_position_id',
				'advertise_size_id',
				'paper_id',
				'advertise_rate_code',
				'advertise_rate_startdate',
				'advertise_rate_enddate',
				'advertise_rate_normal',
				'advertise_rate_discount',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function media()
	{
		return $this->belongsTo('App\Media','media_id');
	}

	public function advertisesize()
	{
		return $this->belongsTo('App\AdvertiseSize','advertise_size_id');
	}

	public function advertiseposition()
	{
		return $this->belongsTo('App\AdvertisePosition','advertise_position_id');
	}

	public function paper()
	{
		return $this->belongsTo('App\Paper', 'paper_id');
	}

	public function inventoryplannerprices()
	{
		return $this->hasMany('App\InventoryPlannerPrice', 'advertise_rate_id');
	}

	public function inventoryplannerprintprices()
	{
		return $this->hasMany('App\InventoryPlannerPrintPrice', 'advertise_rate_id');
	}

	public function inventoryplannerdigitalprices()
	{
		return $this->hasMany('App\InventoryPlannerDigitalPrice', 'advertise_rate_id');
	}

	public function inventoryplannercreativeprices()
	{
		return $this->hasMany('App\InventoryPlannerCreativePrice', 'advertise_rate_id');
	}
}
