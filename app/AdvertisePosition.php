<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisePosition extends Model
{
    protected $table = 'advertise_positions';
	protected $primaryKey = 'advertise_position_id';

	protected $fillable = [
				'advertise_position_name', 'advertise_position_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function advertiserate()
    {
    	return $this->hasMany('App\AdvertiseRate','advertise_position_id');
    }
}
