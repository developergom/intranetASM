<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventPlan extends Model
{
    protected $table = 'event_plans';
	protected $primaryKey = 'event_plan_id';

	protected $fillable = [
				'event_type_id', 
				'event_plan_name',
				'event_plan_desc',
				'event_plan_viewer',
				'location_id',
				'event_plan_deadline',
				'event_plan_year'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function eventtype() {
		return $this->belongsTo('App\EventType', 'event_type_id');
	}

	public function location() {
		return $this->belongsTo('App\Location', 'location_id');
	}

	public function medias() 
	{
		return $this->belongsToMany('App\Media', 'event_plans_medias');
	}

	public function implementations() 
	{
		return $this->belongsToMany('App\Implementation', 'event_plans_implementations');
	}

	public function eventplanhistories()
	{
		return $this->hasMany('App\EventPlanHistory', 'event_plan_id');
	}

	public function uploadfiles() 
	{
		return $this->belongsToMany('App\UploadFile', 'event_plan_upload_file');
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
