<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $table = 'studios';
	protected $primaryKey = 'studio_id';

	protected $fillable = [
				'studio_name', 'studio_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function rates()
	{
		return $this->hasMany('App\Rate', 'studio_id');
	}
}
