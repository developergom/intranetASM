<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $table = 'targets';
	protected $primaryKey = 'target_id';

	protected $fillable = [
				'target_code', 'target_month', 'target_year', 'media_id', 'industry_id', 'target_amount'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function media()
	{
		return $this->belongsTo('App\Media', 'media_id');
	}

	public function industry()
	{
		return $this->belongsTo('App\Industry', 'industry_id');
	}
}
