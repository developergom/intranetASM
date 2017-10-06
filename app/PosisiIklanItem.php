<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosisiIklanItem extends Model
{
    protected $table = 'posisi_iklan_items';
	protected $primaryKey = 'posisi_iklan_id';

	protected $fillable = [
				'posisi_iklan_item_id',
				'posisi_iklan_id', 
				'summary_item_id',
				'client_id',
				'posisi_iklan_item_name',
				'industry_id',
				'sales_id',
				'posisi_iklan_item_page_no',
				'posisi_iklan_item_canal',
				'posisi_iklan_item_order_digital',
				'posisi_iklan_item_materi',
				'posisi_iklan_item_status_materi',
				'posisi_iklan_item_capture_materi',
				'posisi_iklan_item_sales_order',
				'posisi_iklan_item_nett',
				'posisi_iklan_item_ppn',
				'posisi_iklan_item_total',
				'revision_no',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];

	public function posisiiklan()
	{
		return $this->belongsTo('App\PosisiIklan', 'posisi_iklan_id');
	}

	public function summaryitem()
	{
		return $this->belongsTo('App\SummaryItem', 'summary_item_id');
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
}
