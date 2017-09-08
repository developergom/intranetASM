<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';
	protected $primaryKey = 'rate_id';

	protected $fillable = [
				'advertise_rate_type_id',
				'media_id',
				'rate_name',
				'width',
				'length',
				'unit_id',
				'studio_id',
				'duration',
				'duration_type',
				'spot_type_id',
				'gross_rate',
				'discount',
				'nett_rate',
				'start_valid_date',
				'end_valid_date',
				'cinema_tax',
				'paper_id',
				'color_id'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function advertiseratetype()
	{
		return $this->belongsTo('App\AdvertiseRateType','advertise_rate_type_id');
	}

	public function media()
	{
		return $this->belongsTo('App\Media','media_id');
	}

	public function unit()
	{
		return $this->belongsTo('App\Unit', 'unit_id');
	}

	public function studio()
	{
		return $this->belongsTo('App\Studio','studio_id');
	}

	public function spottype()
	{
		return $this->belongsTo('App\SpotType', 'spot_type_id');
	}

	public function paper()
	{
		return $this->belongsTo('App\Paper', 'paper_id');
	}

	public function color()
	{
		return $this->belongsTo('App\Color', 'color_id');
	}
}
