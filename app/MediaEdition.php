<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaEdition extends Model
{
    protected $table = 'media_editions';
	protected $primaryKey = 'media_edition_id';

	protected $fillable = [
				'media_id',
				'media_edition_no',
				'media_edition_publish_date',
				'media_edition_deadline_date',
				'media_edition_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function media()
	{
		return $this->belongsTo('App\Media','media_id');
	}

	public function actionplan()
	{
		return $this->belongsToMany('App\ActionPlan', 'action_plan_media_edition');
	}

	public function inventoryplannerprices()
	{
		return $this->hasMany('App\InventoryPlannerPrice', 'media_edition_id');
	}

	public function inventoryplannerprintprices()
	{
		return $this->hasMany('App\InventoryPlannerPrintPrice', 'media_edition_id');
	}

	public function proposalprintprices()
	{
		return $this->hasMany('App\ProposalPrintPrice', 'media_edition_id');
	}
}
