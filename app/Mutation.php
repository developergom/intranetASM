<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $table = 'mutations';
	protected $primaryKey = 'mutation_id';

	protected $fillable = [
				'mutation_from',
				'mutation_to',
				'mutation_desc',
				'module_id',
				'mutation_item_id',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function _mutation_to()
	{
		return $this->belongsTo('App\User', 'mutation_to');
	}

	public function _mutation_from()
	{
		return $this->belongsTo('App\User', 'mutation_from');
	}

	public function module()
	{
		return $this->belongsTo('App\Module', 'module_id');
	}

	public function _mutation_item($module_type)
	{
		if($module_type=='inventoryplanner')
		{
			return $this->belongsTo('App\InventoryPlanner', 'mutation_item_id');
		}elseif($module_type=='proposal')
		{
			return $this->belongsTo('App\Proposal', 'mutation_item_id');
		}elseif($module_type=='summary')
		{
			return $this->belongsTo('App\Summary', 'mutation_item_id');
		}
	}	
}
