<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    protected $table = 'notification_types';
	protected $primaryKey = 'notification_type_id';

	protected $fillable = [
				'notification_type_code', 'notification_type_name', 'notification_type_url', 'notification_type_desc', 'notification_type_need_confirmation'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function notification() {
		return $this->hasMany('App\Notification', 'notification_type_code', 'notification_type_code');
	}
}
