<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $table = 'downloads';
	protected $primaryKey = 'download_id';

	protected $fillable = [
				'upload_file_id', 
				'download_ip', 
				'download_device', 
				'download_os',
				'download_browser',
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function uploadfile() 
	{
		return $this->belongsTo('App\UploadFile', 'upload_file_id');
	}
}
