<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SummaryItem extends Model
{
    protected $table = 'summary_items';
	protected $primaryKey = 'summary_item_id';

	protected $fillable = [
				'rate_id', 
				'summary_id',
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

	public function summary()
	{
		return $this->belongsTo('App\Summary', 'summary_id');
	}

	public function rate()
	{
		return $this->belongsTo('App\Rate', 'rate_id');
	}

	public function omzettype()
	{
		return $this->belongsTo('App\OmzetType', 'omzet_type_id');

	}

	public function posisiiklanitem()
	{
		return $this->hasOne('App\PosisiIklanItem', 'summary_item_id');
	}
}
