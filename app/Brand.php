<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
	protected $primaryKey = 'brand_id';

	protected $fillable = [
				'subindustry_id', 'brand_code', 'brand_name', 'brand_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function subindustry()
	{
		return $this->belongsTo('App\SubIndustry', 'subindustry_id');
	}
}
