<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubIndustry extends Model
{
    protected $table = 'subindustries';
	protected $primaryKey = 'subindustry_id';

	protected $fillable = [
				'industry_id', 'subindustry_code', 'subindustry_name', 'subindustry_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function industry()
	{
		return $this->belongsTo('App\Industry', 'industry_id');
	}

	public function brand()
	{
		return $this->hasMany('App\Brand', 'brand_id');
	}
}
