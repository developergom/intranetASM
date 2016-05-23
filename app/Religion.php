<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model{
	protected $table = 'religions';
	protected $primaryKey = 'religion_id';

	protected $fillable = [
				'religion_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function user() {
		return $this->belongsTo('App\User');
	}
}