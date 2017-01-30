<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';
	protected $primaryKey = 'project_id';

	protected $fillable = [
				'project_code',
				'project_name',
				'project_periode_start',
				'project_periode_end',
				'project_desc',
				'client_id'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function client()
	{
		return $this->belongsTo('App\Client','client_id');
	}

	public function projecttasks()
	{
		return $this->hasMany('App\ProjectTask', 'project_id');
	}
}
