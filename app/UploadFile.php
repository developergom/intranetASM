<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadFile extends Model
{
    protected $table = 'upload_files';
	protected $primaryKey = 'upload_file_id';

	protected $fillable = [
				'upload_file_type', 
				'upload_file_name', 
				'upload_file_path', 
				'upload_file_size', 
				'upload_file_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function actionplan() 
	{
		return $this->belongsToMany('App\ActionPlan', 'action_plan_upload_file');
	}

	public function downloads()
	{
		return $this->hasMany('App\Download', 'upload_file_id');
	}

	public function eventplan() 
	{
		return $this->belongsToMany('App\EventPlan', 'event_plan_upload_file');
	}

	public function inventoriesplanner()
	{
		return $this->belongsToMany('App\InventoryPlanner', 'inventory_planner_upload_file');
	}

	public function creative() 
	{
		return $this->belongsToMany('App\Creative', 'creative_upload_file');
	}

	public function proposals()
	{
		return $this->belongsToMany('App\Proposal', 'proposal_upload_file');
	}

	public function projects()
	{
		return $this->belongsToMany('App\Project', 'project_upload_file');
	}

	public function projecttasks()
	{
		return $this->belongsToMany('App\ProjectTask', 'project_task_upload_file');
	}

	public function gridproposals()
	{
		return $this->belongsToMany('App\GridProposal', 'grid_proposal_upload_file');
	}
}
