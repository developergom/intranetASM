<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaGroup extends Model
{
    protected $table = 'media_groups';
	protected $primaryKey = 'media_group_id';

	protected $fillable = [
				'publisher_id',
				'media_group_code',
				'media_group_name',
				'media_group_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function users()
	{
        return $this->belongsToMany('App\User','users_media_groups');
    }

	public function media()
	{
		return $this->hasMany('App\Media','media_id');
	}

	public function publisher()
	{
		return $this->belongsTo('App\Publisher', 'publisher_id');
	}

	public function actionplans()
	{
		return $this->belongsToMany('App\ActionPlan', 'action_plan_media_group');
	}
}
