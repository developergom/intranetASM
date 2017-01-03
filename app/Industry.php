<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industries';
	protected $primaryKey = 'industry_id';

	protected $fillable = [
				'industry_code', 'industry_name', 'industry_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function subindustries()
	{
		return $this->hasMany('App\SubIndustry', 'subindustry_id');
	}

	public function proposals()
	{
		return $this->belongsToMany('App\Proposal', 'proposal_industry');
	}
}
