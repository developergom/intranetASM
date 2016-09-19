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

	public function remove($receiver, $notification_type_code, $ref_id)
	{
		$obj = Notification::where('notification_type_code', $notification_type_code)->where('notification_ref_id', $ref_id)->where('notification_receiver', $receiver)->where('active', '1')->first();

		//dd($obj);

		$obj->notification_status = '1';
		$obj->active = '0';
		$obj->updated_by = $receiver;

		$obj->save();
	}
}