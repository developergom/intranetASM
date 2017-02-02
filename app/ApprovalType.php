<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalType extends Model
{
    protected $table = 'approval_types';
	protected $primaryKey = 'approval_type_id';

	protected $fillable = [
				'approval_type_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function actionplanhistories() {
		return $this->hasMany('App\ActionPlanHistory', 'approval_type_id');
	}

	public function eventplanhistories() {
		return $this->hasMany('App\EventPlanHistory', 'approval_type_id');
	}

	public function creativehistories() {
		return $this->hasMany('App\CreativeHistory', 'approval_type_id');
	}

	public function inventoryplannerhistories() {
		return $this->hasMany('App\InventoryPlannerHistory', 'approval_type_id');
	}

	public function proposalhistories() {
		return $this->hasMany('App\ProposalHistory', 'approval_type_id');
	}

	public function projecthistories() {
		return $this->hasMany('App\ProjectHistory', 'approval_type_id');
	}

	public function projecttaskhistories() {
		return $this->hasMany('App\ProjectTaskHistory', 'approval_type_id');
	}

	public function gridproposalhistories() {
		return $this->hasMany('App\GridProposalHistory', 'approval_type_id');
	}
}
