<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SummaryItem extends Model
{
    protected $table = 'summary_items';
	protected $primaryKey = 'summary_item_id';

	protected $fillable = [
				'rate_id', 
				'summary_item_type',
				'summary_item_period_start',
				'summary_item_period_end',
				'omzet_type_id',
				'summary_item_insertion',
				'summary_item_gross',
				'summary_item_disc',
				'summary_item_nett',
				'summary_item_po',
				'summary_item_internal_omzet',
				'revision_no',
				'summary_item_remarks',
				'po_id',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];
}
