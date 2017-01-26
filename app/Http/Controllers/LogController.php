<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Log;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('User Log-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.log.list');
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'log_id';
        $sort_type = 'asc';

        if(is_array($request->input('sort'))) {
            foreach($request->input('sort') as $key => $value)
            {
                $sort_column = $key;
                $sort_type = $value;
            }
        }

        $data = array();
        $data['current'] = intval($current);
        $data['rowCount'] = $rowCount;
        $data['searchPhrase'] = $searchPhrase;
        $data['rows'] = Log::select('users.user_name', 'users.user_firstname', 'users.user_lastname', 'log_ip', 'log_device', 'log_url', 'log_os', 'log_browser', 'logs.created_at as access_time')
        					->join('users','users.user_id', '=', 'logs.created_by')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('user_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_ip','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_device','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_url','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_os','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_browser','like','%' . $searchPhrase . '%')
                                        ->orWhere('logs.created_at','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Log::select('users.user_name', 'users.user_firstname', 'users.user_lastname', 'log_ip', 'log_device', 'log_url', 'log_os', 'log_browser', 'logs.created_at as access_time')
        					->join('users','users.user_id', '=', 'logs.created_by')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('user_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_ip','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_device','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_url','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_os','like','%' . $searchPhrase . '%')
                                        ->orWhere('log_browser','like','%' . $searchPhrase . '%')
                                        ->orWhere('logs.created_at','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }
}
