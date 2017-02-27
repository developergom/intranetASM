<?php

namespace App\Ibrol\Libraries;

use App\Notification;
use App\NotificationType;
use App\User;
use Mail;

class NotificationLibrary{
	public function generate($from, $to, $code, $text, $ref_id, $mail = false, $data = array())
	{
		$obj = new Notification;
		$obj->notification_type_code = $code;
		$obj->notification_text = $text;
		$obj->notification_ref_id = $ref_id;
		$obj->notification_receiver = $to;
		$obj->notification_status = '0';
		$obj->active = '1';
		$obj->created_by = $from;

		$obj->save();

		if($mail==true) {
			$from = User::find($from);
			$to = User::find($to);

			$obj['subject'] = (array_key_exists('subject', $data)) ? $data['subject'] : 'No Subject';
			$obj['to'] = $to->user_email;
			$obj['to_fullname'] = $to->user_firstname . ' ' . $to->user_lastname;
			$obj['from_fullname'] = $from->user_firstname . ' ' . $from->user_lastname;
			$obj['url'] = (array_key_exists('url', $data)) ? $data['url'] : 'http://';

			Mail::send('vendor.material.mail.notification', array('item'=>$obj), function($message) use($obj){
	            $message->to($obj['to'], $obj['to_fullname'])->subject('[* * NOTIFICATION * *] ' . $obj['subject']);
	            //$message->to('soni@gramedia-majalah.com', $obj['to_fullname'])->subject('[* * NOTIFICATION * *] ' . $obj['subject']);
	        });
		}
	}

	public function remove($receiver, $notification_type_code, $ref_id)
	{
		$count = Notification::where('notification_type_code', $notification_type_code)->where('notification_ref_id', $ref_id)->where('notification_receiver', $receiver)->where('active', '1')->count();
		if($count > 0) {
			$obj = Notification::where('notification_type_code', $notification_type_code)->where('notification_ref_id', $ref_id)->where('notification_receiver', $receiver)->where('active', '1')->first();

			$obj->notification_status = '1';
			$obj->active = '0';
			$obj->updated_by = $receiver;

			$obj->save();	
		}
		
	}
}