<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\Project;
use App\ProjectTask;
use App\ProjectTaskHistory;
use App\ProjectTaskType;
use App\UploadFile;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class ProjectTaskController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/grid/projecttask';
    private $notif;

    public function __construct() {
        $flow = new FlowLibrary;
        $this->flows = $flow->getCurrentFlows($this->uri);
        $this->flow_group_id = $this->flows[0]->flow_group_id;

        $this->notif = new NotificationLibrary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Project Task-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.grid.projecttask.list', $data);
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'project_task_id';
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

        if($listtype == 'onprocess') {
            $data['rows'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.current_user')
                                ->where('project_tasks.flow_no','<>','98')
                                ->where('project_tasks.active', '=', '1')
                                ->where('project_tasks.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('project_tasks.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('project_tasks.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.current_user')
                                ->where('project_tasks.flow_no','<>','98')
                                ->where('project_tasks.active', '=', '1')
                                ->where('project_tasks.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('project_tasks.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('project_tasks.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.created_by')
                                ->where('project_tasks.active','1')
                                ->where('project_tasks.flow_no','<>','98')
                                ->where('project_tasks.flow_no','<>','99')
                                ->where('project_tasks.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.created_by')
                                ->where('project_tasks.active','1')
                                ->where('project_tasks.flow_no','<>','98')
                                ->where('project_tasks.flow_no','<>','99')
                                ->where('project_tasks.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.created_by')
                                ->where('project_tasks.active','1')
                                ->where('project_tasks.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('project_tasks.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('project_tasks.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.created_by')
                                ->where('project_tasks.active','1')
                                ->where('project_tasks.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('project_tasks.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('project_tasks.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.created_by')
                                ->where('project_tasks.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('project_tasks.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('project_tasks.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ProjectTask::join('projects', 'projects.project_id', '=', 'project_tasks.project_id')
                                ->join('project_task_types', 'project_task_types.project_task_type_id', '=', 'project_tasks.project_task_type_id')
                                ->join('users','users.user_id', '=', 'project_tasks.created_by')
                                ->where('project_tasks.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('project_tasks.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('project_tasks.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_task_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }
}
