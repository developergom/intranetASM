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

	public function users() {
		return $this->hasMany('App\User','user_id');
	}

	public function clientcontact()
	{
		return $this->hasMany('App\ClientContact', 'client_contact_id');
	}
}