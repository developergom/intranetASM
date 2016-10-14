<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
	protected $primaryKey = 'unit_id';

	protected $fillable = [
				'unit_code',
				'unit_name',
				'unit_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function papers()
	{
		return $this->hasMany('App\Paper','paper_id');
	}

	public function advertisesizes()
	{
		return $this->hasMany('App\AdvertiseSize','unit_id');	
	}

	public function creatives()
	{
		return $this->hasMany('App\Creative','unit_id');		
	}
}
