<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTaskType extends Model
{
    protected $table = 'project_task_types';
	protected $primaryKey = 'project_task_type_id';

	protected $fillable = [
				'project_task_type_name', 'user_id', 'project_task_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function projecttasks()
	{
		return $this->hasMany('App\ProjectTask', 'project_task_type_id');
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id');
	}
}
