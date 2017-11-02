<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\ActionPlan;
use App\Agenda;
use App\ClientContact;
use App\InventoryPlanner;
use App\Proposal;
use App\SummaryItem;

use DB;
use Gate;
use Mail;
use Log;

use App\Announcement;
use Carbon\Carbon;

use App\Ibrol\Libraries\GeneralLibrary;
use App\Ibrol\Libraries\ReportXls;
use App\Ibrol\Libraries\UserLibrary;

class HomeController extends Controller
{
    private $gl;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->gl = new GeneralLibrary;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = array();

        $today = date('Y-m-d');

        $data['month'] = date('m');
        $data['thisyear'] = date('Y');

        $data['years'] = [date('Y'), date('Y')-1, date('Y')-2];

        $data['announcements'] = Announcement::where(function($query) use($today) {
                                                    $query->where('announcement_startdate', '>=', $today)
                                                            ->where('announcement_enddate', '<=', $today);
                                                })->orWhere(function($query) use($today) {
                                                    $query->where('announcement_startdate', '<=', $today)
                                                            ->where('announcement_enddate', '>=', $today);
                                                })->where('active', '=', '1')->get();


        if(Gate::allows('Agenda-Read')) {
            $u = new UserLibrary;
            $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

            $data['my_agenda_subordinate'] = User::whereIn('user_id',$subordinate)->orderBy('user_firstname')->get();
            $data['my_agenda_current'] = User::with('groups')->find($request->user()->user_id);
        }

        if(Gate::allows('TBC Item List-Read')) {
            $u = new UserLibrary;
            $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

            $data['summary_item_tbc'] = SummaryItem::select('summary_items.summary_id', DB::raw('DATE_FORMAT(summary_item_period_start, "%d-%b-%Y") AS summary_item_period_start'), 'summary_item_title', 'client_name', 'summary_item_nett')
                            ->join('summaries','summaries.summary_id', '=', 'summary_items.summary_id')
                            ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                            ->where(function($q) use ($subordinate, $request) {
                                $q->whereIn('summaries.created_by', $subordinate)
                                    ->orWhere('summaries.created_by', $request->user()->user_id);
                            })->where('summary_item_viewed', 'TBC')
                            ->where('summary_items.active', '1')->count();
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

    protected function unusefull()
    {
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
                                        ->orWhere('pic', $request->user()->user_id)
                                        ->orWhere(function($query) use($subordinate) {
                                                    $query->whereIn('pic', $subordinate);
                                                })
                                        ->get();
        }

        if(Gate::allows('Grid Proposal-Read')) {
            $u = new UserLibrary;
            $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);
            $user_on_proposal = DB::select("SELECT created_by from grid_proposals group by created_by");
            $up = array();
            foreach ($user_on_proposal as $uop) {
                array_push($up, $uop->created_by);
            }

            $data['grid_proposal_subordinate'] = User::whereIn('user_id',$subordinate)->whereIn('user_id', $up)->orderBy('user_firstname')->get();
            $data['grid_proposal_current'] = User::with('groups')->find($request->user()->user_id);
            $data['grid_proposal_year'] = date('Y');
        }
    }

    public function apiProposalRecap(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $param = $this->gl->getMonthDate($month, $year);

        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $data['proposal_created'] = Proposal::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('created_at', [$param['start'], $param['end']])
                                            ->count();
        $data['proposal_direct'] = Proposal::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('created_at', [$param['start'], $param['end']])
                                            ->where('proposal_method_id', '2')
                                            ->count();
        $data['proposal_brief'] = Proposal::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('created_at', [$param['start'], $param['end']])
                                            ->where('proposal_method_id', '1')
                                            ->count();
        $data['proposal_sold'] = Proposal::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('created_at', [$param['start'], $param['end']])
                                            ->where('flow_no', '98')
                                            ->where('proposal_status_id', '1')
                                            ->count();

        return response()->json($data); 
    }

    public function apiInventoryRecap(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $param = $this->gl->getMonthDate($month, $year);

        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $data['inventories_created'] = InventoryPlanner::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('inventories_planner.created_at', [$param['start'], $param['end']])
                                            ->count();
        $data['inventories_linked'] = InventoryPlanner::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->whereHas('proposals', function($q) {
                                                $q->where('proposals.active', '1');
                                            })
                                            ->where('inventories_planner.active', '1')
                                            ->whereBetween('inventories_planner.created_at', [$param['start'], $param['end']])
                                            ->count();
        $data['inventories_not_sold'] = InventoryPlanner::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->whereHas('proposals', function($q) {
                                                $q->where('proposals.active', '1')
                                                    ->where('proposals.flow_no', '98')
                                                    ->where('proposal_status_id', '2');
                                            })
                                            ->where('inventories_planner.active', '1')
                                            ->whereBetween('inventories_planner.created_at', [$param['start'], $param['end']])
                                            ->count();
        $data['inventories_sold'] = InventoryPlanner::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->whereHas('proposals', function($q) {
                                                $q->where('proposals.active', '1')
                                                    ->where('proposals.flow_no', '98')
                                                    ->where('proposal_status_id', '1');
                                            })
                                            ->where('inventories_planner.active', '1')
                                            ->whereBetween('inventories_planner.created_at', [$param['start'], $param['end']])
                                            ->count(); 

        return response()->json($data); 
    }

    public function apiAgendaRecap(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $param = $this->gl->getMonthDate($month, $year);

        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        //total created
        $data['agenda_total_created'] = Agenda::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('agendas.created_at', [$param['start'], $param['end']])
                                            ->count();
        //total reported
        $data['agenda_total_reported'] = Agenda::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('agendas.created_at', [$param['start'], $param['end']])
                                            ->where('agenda_is_report', '1')
                                            ->count();

        //detailing
        $data['agenda_details'] = Agenda::select('agenda_type_name', DB::raw('COUNT(agendas.agenda_id) AS total'))
                                            ->join('agenda_types', 'agenda_types.agenda_type_id', '=', 'agendas.agenda_type_id')
                                            ->where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('agendas.created_by', $subordinate)
                                                    ->orWhere('agendas.created_by', $request->user()->user_id);
                                                })
                                            ->where('agendas.active', '1')
                                            ->whereBetween('agendas.created_at', [$param['start'], $param['end']])
                                            ->groupBy('agenda_type_name')
                                            ->orderBy('total', 'desc')
                                            ->get();

        return response()->json($data); 
    }

    public function apiContactRecap(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $param = $this->gl->getMonthDate($month, $year);

        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $data['contact_created'] = ClientContact::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('created_by', $subordinate)
                                                    ->orWhere('created_by', $request->user()->user_id);
                                                })
                                            ->where('client_contacts.active', '1')
                                            ->whereBetween('created_at', [$param['start'], $param['end']])
                                            ->count();
        $data['contact_updated'] = ClientContact::where(function($q) use ($subordinate, $request) {
                                                $q->whereIn('updated_by', $subordinate)
                                                    ->orWhere('updated_by', $request->user()->user_id);
                                                })
                                            ->where('client_contacts.active', '1')
                                            ->whereBetween('updated_at', [$param['start'], $param['end']])
                                            ->count();

        return response()->json($data); 
    }
}
