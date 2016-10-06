<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';
	protected $primaryKey = 'announcement_id';

	protected $fillable = [
				'announcement_title',
				'announcement_detail',
				'announcement_startdate',
				'announcement_enddate',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];
}
