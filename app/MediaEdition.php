<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaEdition extends Model
{
    protected $table = 'media_editions';
	protected $primaryKey = 'media_edition_id';

	protected $fillable = [
				'media_id',
				'media_edition_no',
				'media_edition_publish_date',
				'media_edition_deadline_date',
				'media_edition_desc',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function media()
	{
		return $this->belongsTo('App\Media','media_id');
	}
}
