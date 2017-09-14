<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OmzetType extends Model
{
    protected $table = 'omzet_types';
	protected $primaryKey = 'omzet_type_id';

	protected $fillable = [
				'omzet_type_name',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];
}
