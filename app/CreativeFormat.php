<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreativeFormat extends Model
{
    protected $table = 'creative_formats';
	protected $primaryKey = 'creative_format_id';

	protected $fillable = [
				'creative_format_name', 'creative_format_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];
}
