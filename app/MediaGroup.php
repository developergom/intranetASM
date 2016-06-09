<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaGroup extends Model
{
    protected $table = 'media_groups';
	protected $primaryKey = 'media_group_id';

	protected $fillable = [
				'media_group_code',
				'media_group_name',
				'media_group_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function media()
	{
		return $this->hasMany('App\Media','media_id');
	}
}
