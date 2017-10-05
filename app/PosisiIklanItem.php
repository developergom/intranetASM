<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosisiIklanItem extends Model
{
    protected $table = 'posisi_iklan_items';
	protected $primaryKey = 'posisi_iklan_id';

	protected $fillable = [
				'posisi_iklan_item_id'
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
}
