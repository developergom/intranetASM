<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Notification;
use Response;

class NotificationController extends Controller
{
    public function loadNotification(Request $request) {
    	$data = array();

    	$data['notifications'] = Notification::join('users', 'users.user_id', '=', 'notifications.created_by')
                                            ->join('notification_types', 'notification_types.notification_type_code', '=', 'notifications.notification_type_code')
    										->where('notifications.notification_receiver', '=', $request->user()->user_id)
    										->where('notifications.active', '=', '1')
    										/*->where('notification_status', '=', '0')*/
                                            ->take(6)
                                            ->orderBy('notifications.created_at', 'desc')
    										->get();

    	$data['total'] = Notification::join('users', 'users.user_id', '=', 'notifications.created_by')
                                            ->join('notification_types', 'notification_types.notification_type_code', '=', 'notifications.notification_type_code')
    										->where('notifications.notification_receiver', '=', $request->user()->user_id)
    										->where('notifications.active', '=', '1')
    										/*->where('notification_status', '=', '0')*/
                                            ->take(6)
                                            ->orderBy('notifications.created_at', 'desc')
    										->count();

    	echo json_encode($data);
    }

    public function sendNotification(Request $request) {
        $this->validate($request, [
            'notification_id' => 'required',
            'notification_status' => 'required'
        ]);

        $obj = Notification::find($request->input('notification_id'));

        $obj->notification_status = $request->input('notification_status');
        $obj->notification_senttime = Carbon::now()->format('Y-m-d H:i:s');
        $obj->updated_by = $request->user()->user_id;

        $result = $obj->save();

        if($result) {
            return Response::json('success', 200);
        }else{
            return Response::json('error', 400);
        }
    }

    public function readNotification(Request $request) {
        $this->validate($request, [
            'notification_id' => 'required'
        ]);

        $obj = Notification::find($request->input('notification_id'));

        $obj->notification_readtime = Carbon::now()->format('Y-m-d H:i:s');
        $obj->updated_by = $request->user()->user_id;

        /*dd($obj->notification_type);*/

        if($obj->notification_type->notification_type_need_confirmation==0) {
            $obj->active = '0';
        }

        $result = $obj->save();

        if($result) {
            return Response::json('success', 200);
        }else{
            return Response::json('error', 400);
        }
    }
}
