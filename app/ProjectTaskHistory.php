<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTaskHistory extends Model
{
    protected $table = 'project_task_histories';
	protected $primaryKey = 'project_task_history_id';

	protected $fillable = [
				'project_task_id', 
				'approval_type_id', 
				'project_task_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function projecttask()
	{
		return $this->belongsTo('App\ProjectTask', 'project_task_id');
	}

	public function approvaltype()
	{
		return $this->belongsTo('App\ApprovalType', 'approval_type_id');	
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}
}
