<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'medias';
	protected $primaryKey = 'media_id';

	protected $fillable = [
				'media_group_id',
				'media_category_id',
				'media_code',
				'media_name',
				'media_logo',
				'media_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function mediacategory()
	{
		return $this->belongsTo('App\MediaCategory','media_category_id');
	}

	public function mediagroup()
	{
		return $this->belongsTo('App\MediaGroup','media_group_id');
	}

	public function users()
	{
        return $this->belongsToMany('App\User','users_medias');
    }

    public function mediaedition()
    {
    	return $this->hasMany('App\MediaEdition','media_edition_id');
    }

    public function advertiserate()
    {
    	return $this->hasMany('App\AdvertiseRate','advertise_rate_id');
    }
}
