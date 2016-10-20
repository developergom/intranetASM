<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
	protected $primaryKey = 'location_id';

	protected $fillable = [
				'location_name', 'location_address', 'location_city', 'location_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function eventplans() {
		return $this->hasMany('App\EventPlan', 'location_id');
	}
}
