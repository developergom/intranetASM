<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creative extends Model
{
    protected $table = 'creatives';
	protected $primaryKey = 'creative_id';

	protected $fillable = [
				'creative_format_id', 
				'creative_name',
				'media_category_id',
				'creative_width',
				'creative_height',
				'unit_id',
				'creative_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function creativeformat() {
		return $this->belongsTo('App\CreativeFormat', 'creative_format_id');
	}

	public function medias() 
	{
		return $this->belongsToMany('App\Media', 'creatives_medias');
	}

	public function mediacategory() 
	{
		return $this->belongsTo('App\MediaCategory', 'media_category_id');
	}

	public function creativehistories()
	{
		return $this->hasMany('App\CreativeHistory', 'creative_id');
	}

	public function uploadfiles() 
	{
		return $this->belongsToMany('App\UploadFile', 'creative_upload_file');
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
