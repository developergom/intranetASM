<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertiseSize extends Model
{
    protected $table = 'advertise_sizes';
	protected $primaryKey = 'advertise_size_id';

	protected $fillable = [
				'advertise_size_code',
				'advertise_size_name',
				'advertise_size_desc',
				'unit_id',
				'advertise_size_width',
				'advertise_size_length',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function unit()
	{
		return $this->belongsTo('App\Unit','unit_id');
	}

	public function advertiserate()
    {
    	return $this->hasMany('App\AdvertiseRate','advertise_rate_id');
    }
}
