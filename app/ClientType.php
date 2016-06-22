<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientType extends Model
{
    protected $table = 'client_types';
	protected $primaryKey = 'client_type_id';

	protected $fillable = [
				'client_type_name', 'client_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function client()
	{
		return $this->hasMany('App\Client', 'client_id');
	}
}
