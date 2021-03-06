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
				'page_no',
				'summary_item_canal',
				'summary_item_order_digital',
				'summary_item_materi',
				'summary_item_status_materi',
				'summary_item_capture_materi',
				'summary_item_sales_order',
				'summary_item_po_perjanjian',
				'summary_item_ppn',
				'summary_item_total',
				'summary_item_title',
				'client_id',
				'industry_id',
				'sales_id',
				'summary_item_pic',
				'summary_item_task_status',
				'summary_item_termin',
				'summary_item_viewed',
				'source_type',
				'summary_item_edited',
				'revision_no',
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

	public function posisiiklanitemtask()
	{
		return $this->hasOne('App\PosisiIklanItemTask', 'summary_item_id');
	}

	public function client()
	{
		return $this->belongsTo('App\Client', 'client_id');
	}

	public function industry()
	{
		return $this->belongsTo('App\Industry', 'industry_id');
	}

	public function sales()
	{
		return $this->belongsTo('App\User', 'sales_id', 'user_id');
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}
}
