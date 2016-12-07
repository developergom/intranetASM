<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
	protected $primaryKey = 'log_id';

	protected $fillable = [
				'log_url', 
				'log_ip', 
				'log_device', 
				'log_os',
				'log_browser',
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_at'
	];
}
