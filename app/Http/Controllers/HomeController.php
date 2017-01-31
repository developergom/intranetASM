<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\ActionPlan;
use App\EventPlan;
use App\Creative;
use App\Project;
use App\ProjectTask;
use App\ProjectTaskType;
use DB;
use Gate;
use Mail;
use Log;

use App\Announcement;
use Carbon\Carbon;

use App\Ibrol\Libraries\UserLibrary;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();

        $data['waktu'] = date('Y-m-d H:i:s');

        $today = date('Y-m-d');

        $data['announcements'] = Announcement::where(function($query) use($today) {
                                                    $query->where('announcement_startdate', '>=', $today)
                                                            ->where('announcement_enddate', '<=', $today);
                                                })->orWhere(function($query) use($today) {
                                                    $query->where('announcement_startdate', '<=', $today)
                                                            ->where('announcement_enddate', '>=', $today);
                                                })->where('active', '=', '1')->get();

        
        //dd($data['logs']);
        $data['eventplan'] = EventPlan::where('active', '1')->where('flow_no', '98')->where(DB::raw('datediff("'.date('Y-m-d').'", event_plan_deadline)'), '>', 30)->get();

        if(Gate::allows('Project Task-Approval')) {
            $u = new UserLibrary;
            $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

            $data['project_task_subordinate'] = User::whereIn('user_id',$subordinate)->orderBy('user_firstname')->get();
            $data['project_task_current'] = User::with('groups')->find($request->user()->user_id);
            $data['project_task_types'] = ProjectTaskType::where('active', '1')->orderBy('project_task_type_name')->get();
            /*$data['project_tasks'] = ProjectTask::where('created_by', $request->user()->user_id)
                                                ->orWhere('pic', $request->user()->user_id)
                                                ->orWhere(function($query) use($subordinate) {
                                                    $query->whereIn('created_by', $subordinate);
                                                })
                                                ->orWhere(function($query) use($subordinate) {
                                                    $query->whereIn('pic', $subordinate);
                                                })
                                                ->where('active', '1')
                                                ->get();*/
            $data['projects'] = Project::where('active', '1')
                                        ->where('created_by', $request->user()->user_id)
                                        ->orWhere(function($query) use($subordinate) {
                                                    $query->whereIn('created_by', $subordinate);
                                                })
                                        ->get();
        }

        return view('home', $data);
    }

    public function apiPlan()
    {
        $data = array();
        $data['monthly'] = array();

        $actionplan = ActionPlan::join('action_plan_media_edition', 'action_plan_media_edition.action_plan_id', '=', 'action_plans.action_plan_id')
                                ->join('media_editions', 'media_editions.media_edition_id', '=', 'action_plan_media_edition.media_edition_id')
                                ->where('action_plans.active', '1')->where('action_plans.flow_no', '98')->get();
        foreach ($actionplan as $key => $value) {
            $ap = array();
            $ap['id'] = $value->action_plan_id;
            $ap['name'] = $value->action_plan_title;
            $ap['startdate'] = $value->media_edition_deadline_date;
            $ap['enddate'] = $value->media_edition_deadline_date;
            $ap['starttime'] = '0:00';
            $ap['endtime'] = '23:59';
            $ap['color'] = '#FFB128';
            $ap['url'] = '#';
            array_push($data['monthly'], $ap);
        }

        $digitalplan = ActionPlan::where('active', '1')->where('flow_no', '98')->get();
        foreach ($digitalplan as $key => $value) {
            $dp = array();
            $dp['id'] = $value->action_plan_id;
            $dp['name'] = $value->action_plan_title;
            $dp['startdate'] = $value->action_plan_startdate;
            $dp['enddate'] = $value->action_plan_startdate;
            $dp['starttime'] = '0:00';
            $dp['endtime'] = '23:59';
            $dp['color'] = '#FFB128';
            $dp['url'] = '#';
            array_push($data['monthly'], $dp);
        }

        $eventplan = EventPlan::where('active', '1')->where('flow_no', '98')->get();
        foreach ($eventplan as $key => $value) {
            $ep = array();
            $ep['id'] = $value->event_plan_id;
            $ep['name'] = $value->event_plan_name;
            $ep['startdate'] = $value->event_plan_deadline;
            $ep['enddate'] = '';
            $ep['starttime'] = '0:00';
            $ep['endtime'] = '23:59';
            $ep['color'] = '#4286f4';
            $ep['url'] = '#';
            array_push($data['monthly'], $ep);
        }

        return response()->json($data);
    }

    public function apiUpcomingPlan($mode, $day)
    {
        if($mode=='below')
        {
            $sym = '>';
        }else{
            $sym = '<';
        }

        $curdate = date('Y-m-d');

        $data = array();
        $data['monthly'] = array();

        $actionplan = ActionPlan::join('action_plan_media_edition', 'action_plan_media_edition.action_plan_id', '=', 'action_plans.action_plan_id')
                                ->join('media_editions', 'media_editions.media_edition_id', '=', 'action_plan_media_edition.media_edition_id')
                                ->select(DB::raw('action_plans.*, media_edition_deadline_date, ABS(datediff("'.$curdate.'", media_edition_deadline_date)) AS timeto'))
                                ->where('action_plans.active', '1')
                                ->where('flow_no', '98')
                                ->where(DB::raw('datediff("'.$curdate.'", media_edition_deadline_date)'), $sym, $day)
                                ->where(DB::raw('datediff("'.$curdate.'", media_edition_deadline_date)'), '<', 0)
                                ->orderBy('media_edition_deadline_date', 'asc')
                                ->take(5)
                                ->get();
        foreach ($actionplan as $key => $value) {
            $ap = array();
            $ap['id'] = $value->action_plan_id;
            $ap['name'] = $value->action_plan_title;
            $ap['startdate'] = $value->media_edition_deadline_date;
            $ap['enddate'] = $value->media_edition_deadline_date;
            $ap['starttime'] = '0:00';
            $ap['endtime'] = '23:59';
            $ap['color'] = '#FFB128';
            $ap['url'] = '#';
            $ap['timeto'] = $value->timeto;
            array_push($data['monthly'], $ap);
        }

        $digitalplan = ActionPlan::select('action_plans.*',
                                    DB::raw('ABS(datediff("'.$curdate.'", action_plan_startdate)) AS timeto')
                                )
                                ->where('active', '1')
                                ->where('flow_no', '98')
                                ->where(DB::raw('datediff("'.$curdate.'", action_plan_startdate)'), $sym, $day)
                                ->where(DB::raw('datediff("'.$curdate.'", action_plan_startdate)'), '<', 0)
                                ->orderBy('action_plan_startdate', 'asc')
                                ->take(5)
                                ->get();
        foreach ($digitalplan as $key => $value) {
            $dp = array();
            $dp['id'] = $value->action_plan_id;
            $dp['name'] = $value->action_plan_title;
            $dp['startdate'] = $value->action_plan_startdate;
            $dp['enddate'] = $value->action_plan_startdate;
            $dp['starttime'] = '0:00';
            $dp['endtime'] = '23:59';
            $dp['color'] = '#FFB128';
            $dp['url'] = '#';
            $dp['timeto'] = $value->timeto;
            array_push($data['monthly'], $dp);
        }

        $eventplan = EventPlan::select('event_plans.*',DB::raw('ABS(datediff("'.$curdate.'", event_plan_deadline)) AS timeto'))->where('active', '1')->where('flow_no', '98')->where(DB::raw('datediff("'.$curdate.'", event_plan_deadline)'), $sym, $day)->where(DB::raw('datediff("'.$curdate.'", event_plan_deadline)'), '<', 0)->orderBy('event_plan_deadline', 'asc')->take(5)->get();
        foreach ($eventplan as $key => $value) {
            $ep = array();
            $ep['id'] = $value->event_plan_id;
            $ep['name'] = $value->event_plan_name;
            $ep['startdate'] = $value->event_plan_deadline;
            $ep['enddate'] = '';
            $ep['starttime'] = '0:00';
            $ep['endtime'] = '23:59';
            $ep['color'] = '#4286f4';
            $ep['url'] = '#';
            $ep['timeto'] = $value->timeto;
            array_push($data['monthly'], $ep);
        }

        return response()->json($data);
    }
}
