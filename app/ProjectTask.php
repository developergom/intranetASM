<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ProjectTask extends Model
{
    protected $table = 'project_tasks';
	protected $primaryKey = 'project_task_id';

	protected $fillable = [
				'project_id', 
				'project_task_type_id', 
				'project_task_name',
				'project_task_deadline',
				'project_task_desc',
				'project_task_ready_date',
				'project_task_delivery_date',
				'pic',
				'flow_no',
				'revision_no',
				'current_user',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function project()
	{
		return $this->belongsTo('App\Project', 'project_id');
	}

	public function projecttasktype()
	{
		return $this->belongsTo('App\ProjectTaskType', 'project_task_type_id');
	}

	public function projecttaskhistories()
	{
		return $this->hasMany('App\ProjectTaskHistory', 'project_task_id');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'project_task_upload_file');
	}

	public function _currentuser()
	{
		return $this->belongsTo('App\User', 'current_user');
	}

	public function _pic()
	{
		return $this->belongsTo('App\User', 'pic');	
	}
}
