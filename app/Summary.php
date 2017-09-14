<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $table = 'summaries';
	protected $primaryKey = 'summary_id';

	protected $fillable = [
				'proposal_id', 
				'summary_order_no',
				'summary_sent_date',
				'summary_total_gross',
				'summary_total_disc',
				'summary_total_nett',
				'summary_total_po',
				'summary_total_internal_omzet',
				'top_type',
				'top_count',
				'revision_no',
				'current_user',
				'flow_no',
				'pic',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];
}
