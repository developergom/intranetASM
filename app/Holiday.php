<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Holiday extends Model
{
    protected $table = 'holidays';
	protected $primaryKey = 'holiday_id';

	protected $fillable = [
				'holiday_name',
				'holiday_date',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	protected $dates = ['created_at', 'updated_at', 'holiday_date'];
}
