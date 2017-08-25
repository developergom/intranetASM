<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiseRateType extends Model
{
    protected $table = 'advertise_rate_types';
	protected $primaryKey = 'advertise_rate_type_id';

	protected $fillable = [
				'advertise_rate_type_name', 'advertise_rate_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];
}
