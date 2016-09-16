<?php

namespace App\Ibrol\Libraries;

use App\Notification;
use App\NotificationType;

class NotificationLibrary{
	public function generate($from, $to, $code, $text, $ref_id)
	{
		$obj = new Notification;
		$obj->notification_type_code = $code;
		$obj->notification_text = $text;
		$obj->notification_ref_id = $ref_id;
		$obj->notification_receiver = $to;
		$obj->notification_status = '0';
		$obj->active = '1';
		$obj->created_by = $from;

		/*if($obj->save())
		{
			return true;
		}else{
			return false;
		}*/
		$obj->save();
	}

	public function read($receiver, $ref_id)
	{
		$obj = Notification::where('notification_ref_id', $ref_id)->where('notification_receiver', $receiver)->first();

		$obj->status = '0';

		$obj->save();
	}
}