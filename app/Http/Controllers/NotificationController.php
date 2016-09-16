<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\Notification;

class NotificationController extends Controller
{
    public function loadNotification(Request $request) {
    	$data = array();

    	$data['notifications'] = Notification::join('users', 'users.user_id', '=', 'notifications.created_by')
    										->where('notifications.created_by', '=', $request->user()->user_id)
    										->where('notifications.active', '=', '1')
    										->where('notification_status', '=', '0')
    										->get();

    	$data['total'] = Notification::join('users', 'users.user_id', '=', 'notifications.created_by')
    										->where('notifications.created_by', '=', $request->user()->user_id)
    										->where('notifications.active', '=', '1')
    										->where('notification_status', '=', '0')
    										->count();

    	echo json_encode($data);
    }
}
