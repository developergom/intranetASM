<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalMethod extends Model
{
    protected $table = 'proposal_methods';
	protected $primaryKey = 'proposal_method_id';

	protected $fillable = [
				'proposal_method_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function proposals()
	{
		return $this->hasMany('App\Proposal', 'proposal_method_id');
	}
}
