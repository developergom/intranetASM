<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $table = 'publishers';
	protected $primaryKey = 'publisher_id';

	protected $fillable = [
				'publisher_code',
				'publisher_name',
				'publisher_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function mediagroup()
	{
		return $this->hasMany('App\MediaGroup','publisher_id');
	}
}
