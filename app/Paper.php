<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table = 'papers';
	protected $primaryKey = 'paper_id';

	protected $fillable = [
				'unit_id',
				'paper_name',
				'paper_width',
				'paper_length',
				'paper_desc',
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
    	return $this->hasMany('App\AdvertiseRate','paper_id');
    }
}
