<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use Carbon\Carbon;
use App\Http\Requests;
use App\Activity;
use App\ActivityType;
use App\Agenda;
use App\AgendaType;

use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Activity-Read')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.material.agenda.activity.list');
    }

    public function apiList(Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'activity_type_id';
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
        $data['rows'] = Activity::join('activity_types', 'activity_types.activity_type_id', '=', 'activities.activity_type_id')
                            ->join('users', 'users.user_id', '=', 'activities.created_by')
                            ->where('activities.active','1')
                            ->where(function($query) use($request, $subordinate){
                                    $query->where('activities.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('activities.created_by', $subordinate);
                                })
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('activity_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('activity_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('activity_destination','like','%' . $searchPhrase . '%')
                                        ->orWhere('activity_status','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Activity::join('activity_types', 'activity_types.activity_type_id', '=', 'activities.activity_type_id')
                            ->join('users', 'users.user_id', '=', 'activities.created_by')
                            ->where('activities.active','1')
                            ->where(function($query) use($request, $subordinate){
                                    $query->where('activities.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('activities.created_by', $subordinate);
                                })
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('activity_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('activity_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('activity_destination','like','%' . $searchPhrase . '%')
                                        ->orWhere('activity_status','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }
}
