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

	public function inventoryplannerprintprices()
	{
		return $this->hasMany('App\InventoryPlannerPrintPrice', 'price_type_id');
	}

	public function inventoryplannerdigitalprices()
	{
		return $this->hasMany('App\InventoryPlannerDigitalPrice', 'price_type_id');
	}

	public function inventoryplannereventprices()
	{
		return $this->hasMany('App\InventoryPlannerEventPrice', 'price_type_id');
	}

	public function inventoryplannercreativeprices()
	{
		return $this->hasMany('App\InventoryPlannerCreativePrice', 'price_type_id');
	}

	public function inventoryplannerotherprices()
	{
		return $this->hasMany('App\InventoryPlannerOtherPrice', 'price_type_id');
	}

	public function proposalprintprices()
	{
		return $this->hasMany('App\ProposalPrintPrice', 'price_type_id');
	}

	public function proposaldigitalprices()
	{
		return $this->hasMany('App\ProposalDigitalPrice', 'price_type_id');
	}

	public function proposaleventprices()
	{
		return $this->hasMany('App\ProposalEventPrice', 'price_type_id');
	}

	public function proposalcreativeprices()
	{
		return $this->hasMany('App\ProposalCreativePrice', 'price_type_id');
	}

	public function proposalotherprices()
	{
		return $this->hasMany('App\ProposalOtherPrice', 'price_type_id');
	}
}
