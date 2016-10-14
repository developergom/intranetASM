<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaCategory extends Model
{
    protected $table = 'media_categories';
	protected $primaryKey = 'media_category_id';

	protected $fillable = [
				'media_category_name',
				'media_category_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function media()
	{
		return $this->hasMany('App\Media','media_category_id');
	}

	public function creatives()
	{
		return $this->hasMany('App\Creative','media_category_id');	
	}
}
