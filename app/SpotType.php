<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotType extends Model
{
    protected $table = 'spot_types';
	protected $primaryKey = 'spot_type_id';

	protected $fillable = [
				'spot_type_name', 'spot_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function rates()
	{
		return $this->hasMany('App\Rate', 'spot_type_id');
	}
}
