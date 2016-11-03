<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalStatus extends Model
{
    protected $table = 'proposal_status';
	protected $primaryKey = 'proposal_status_id';

	protected $fillable = [
				'proposal_status_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];
}
