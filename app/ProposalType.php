<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalType extends Model
{
    protected $table = 'proposal_types';
	protected $primaryKey = 'proposal_type_id';

	protected $fillable = [
				'proposal_type_name', 'proposal_type_duration', 'proposal_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function proposals()
	{
		return $this->hasMany('App\Proposal', 'proposal_type_id');
	}

	public function inventories_planner()
	{
		return $this->hasMany('App\InventoryPlanner', 'proposal_type_id');
	}
}
