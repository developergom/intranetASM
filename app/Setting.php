<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
	protected $primaryKey = 'setting_id';

	protected $fillable = [
				'setting_code',
				'setting_name',
				'setting_desc',
				'setting_value',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];
}
