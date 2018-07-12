<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalCostDetails extends Model
{
    protected $primaryKey = 'proposal_cost_details_id';

    protected $fillable = [
    			'proposal_id', 
				'proposal_cost',
				'proposal_media_cost_print',
				'proposal_media_cost_other',
				'proposal_total_offering',
				'status',
				'revision_no',
    ];
}
