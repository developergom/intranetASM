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
				'client_id',
				'project_ready_date',
				'project_delivery_date',
				'pic',
				'flow_no',
				'revision_no',
				'current_user',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function client()
	{
		return $this->belongsTo('App\Client','client_id');
	}

	public function projecthistories()
	{
		return $this->hasMany('App\ProjectHistory', 'project_id');
	}

	public function projecttasks()
	{
		return $this->hasMany('App\ProjectTask', 'project_id');
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
