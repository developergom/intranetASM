<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryPlanner extends Model
{
    protected $table = 'inventories_planner';
	protected $primaryKey = 'inventory_planner_id';

	protected $fillable = [
				'inventory_type_id', /*
				'inventory_category_id', */
				'inventory_planner_title',
				'inventory_planner_deadline',
				'inventory_planner_participants',
				'inventory_planner_desc',
				'flow_no',
				'revision_no',
				'current_user',
				'updated_at',
				'created_by',
	];

	protected $hidden = [
				'active', 'created_at', 'updated_by'
	];

	public function agendas()
	{
		return $this->belongsToMany('App\Agenda', 'agendas_inventories');
	}

	public function activities()
	{
		return $this->belongsToMany('App\Activity', 'activites_inventories');
	}

	public function inventorytype()
	{
		return $this->belongsTo('App\InventoryType', 'inventory_type_id');
	}

	public function proposaltype()
	{
		return $this->belongsTo('App\ProposalType', 'proposal_type_id');
	}

	public function inventorycategories()
	{
		return $this->belongsToMany('App\InventoryCategory', 'inventory_category_inventory_planner');
	}

	public function medias() 
	{
		return $this->belongsToMany('App\Media', 'inventory_planner_media');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'inventory_planner_upload_file');
	}

	public function actionplans()
	{
		return $this->belongsToMany('App\ActionPlan', 'inventory_planner_action_plan');
	}

	public function eventplans()
	{
		return $this->belongsToMany('App\EventPlan', 'inventory_planner_event_plan');
	}

	public function implementations()
	{
		return $this->belongsToMany('App\Implementation', 'inventory_planner_implementation');
	}

	public function inventoryplannerprices()
	{
		return $this->hasMany('App\InventoryPlannerPrice', 'inventory_planner_id');
	}

	public function inventoryplannerprintprices()
	{
		return $this->hasMany('App\InventoryPlannerPrintPrice', 'inventory_planner_id');
	}

	public function inventoryplannerdigitalprices()
	{
		return $this->hasMany('App\InventoryPlannerDigitalPrice', 'inventory_planner_id');
	}

	public function inventoryplannereventprices()
	{
		return $this->hasMany('App\InventoryPlannerEventPrice', 'inventory_planner_id');
	}

	public function inventoryplannercreativeprices()
	{
		return $this->hasMany('App\InventoryPlannerCreativePrice', 'inventory_planner_id');
	}

	public function inventoryplannerotherprices()
	{
		return $this->hasMany('App\InventoryPlannerOtherPrice', 'inventory_planner_id');
	}

	public function inventoryplannerhistories()
	{
		return $this->hasMany('App\InventoryPlannerHistory', 'inventory_planner_id');
	}

	public function proposals()
	{
		return $this->belongsToMany('App\Proposal', 'proposal_inventory_planner');
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function mutationitems()
	{
		return $this->hasMany('App\Mutation', 'mutation_item');
	}
}
