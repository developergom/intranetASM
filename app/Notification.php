<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
	protected $primaryKey = 'notification_id';

	protected $fillable = [
				'notification_type_code', 'notification_text', 'notification_ref_id', 'notification_receiver', 'notification_senttime', 'notification_readtime', 'notification_status'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function notification_type() {
		return $this->belongsTo('App\NotificationType', 'notification_type_code', 'notification_type_code');
	}
}
