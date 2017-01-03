<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
	protected $primaryKey = 'media_id';

	protected $fillable = [
				'media_group_id',
				'media_category_id',
				'media_code',
				'media_name',
				'media_logo',
				'media_circulation',
				'media_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function mediacategory()
	{
		return $this->belongsTo('App\MediaCategory','media_category_id');
	}

	public function mediagroup()
	{
		return $this->belongsTo('App\MediaGroup','media_group_id');
	}

	public function users()
	{
        return $this->belongsToMany('App\User','users_medias');
    }

    public function mediaedition()
    {
    	return $this->hasMany('App\MediaEdition','media_id');
    }

    public function advertiserate()
    {
    	return $this->hasMany('App\AdvertiseRate','advertise_rate_id');
    }

    public function actionplan()
    {
    	return $this->belongsToMany('App\ActionPlan','action_plan_media');
    }

    public function eventplans()
    {
    	return $this->belongsToMany('App\EventPlan','action_plans_medias');
    }

    public function inventoriesplanner()
	{
		return $this->belongsToMany('App\InventoryPlanner', 'inventory_planner_media');
	}

	public function inventoryplannerprices()
	{
		return $this->hasMany('App\InventoryPlannerPrice', 'media_id');
	}

	public function inventoryplannerprintprices()
	{
		return $this->hasMany('App\InventoryPlannerPrintPrice', 'media_id');
	}

	public function inventoryplannerdigitalprices()
	{
		return $this->hasMany('App\InventoryPlannerDigitalPrice', 'media_id');
	}

	public function inventoryplannereventprices()
	{
		return $this->hasMany('App\InventoryPlannerEventPrice', 'media_id');
	}

	public function inventoryplannercreativeprices()
	{
		return $this->hasMany('App\InventoryPlannerCreativePrice', 'media_id');
	}

	public function inventoryplannerotherprices()
	{
		return $this->hasMany('App\InventoryPlannerOtherPrice', 'media_id');
	}

	public function proposals()
	{
		return $this->belongsToMany('App\Proposal', 'proposal_media');
	}

	public function proposalprintprices()
	{
		return $this->hasMany('App\ProposalPrintPrice', 'media_id');
	}

	public function proposaldigitalprices()
	{
		return $this->hasMany('App\ProposalDigitalPrice', 'media_id');
	}

	public function proposaleventprices()
	{
		return $this->hasMany('App\ProposalEventPrice', 'media_id');
	}

	public function proposalcreativeprices()
	{
		return $this->hasMany('App\ProposalCreativePrice', 'media_id');
	}

	public function proposalotherprices()
	{
		return $this->hasMany('App\ProposalOtherPrice', 'media_id');
	}
}
