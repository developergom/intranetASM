<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosisiIklanItemTask extends Model
{
    protected $table = 'posisi_iklan_item_tasks';
	protected $primaryKey = 'posisi_iklan_item_task_id';

	protected $fillable = [
				'summary_item_id',
				'posisi_iklan_item_task_pic',
				'posisi_iklan_item_task_status',
				'posisi_iklan_item_task_finish_time',
				'posisi_iklan_item_task_notes',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];

	public function summaryitem()
	{
		return $this->belongsTo('App\SummaryItem', 'summary_item_id');
	}

	public function _pic()
	{
		return $this->belongsTo('App\User', 'posisi_iklan_item_task_pic', 'user_id');
	}
}
