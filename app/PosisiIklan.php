<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PosisiIklan extends Model
{
    protected $table = 'posisi_iklan';
	protected $primaryKey = 'posisi_iklan_id';

	protected $fillable = [
				'posisi_iklan_id', 
				'posisi_iklan_code',
				'media_id',
				'posisi_iklan_month',
				'posisi_iklan_year',
				'posisi_iklan_edition',
				'posisi_iklan_type',
				'posisi_iklan_notes',
				'revision_no',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];

	public function media()
	{
		$this->belongsTo('App\Media', 'media_id');
	}
}
