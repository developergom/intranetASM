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

    public function create(Request $request)
    {
		if(Gate::denies('Project Task-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['project_task_types'] = ProjectTaskType::with('user')->where('active', '1')->orderBy('project_task_type_name')->get();

     	return view('vendor.material.grid.projecttask.create', $data);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        	'project_task_type_id' => 'required',
            'project_task_name' => 'required|max:100',
            'project_task_deadline' => 'required|date_format:"d/m/Y"',
            'project_task_desc' => 'required',
            'project_id' => 'required'
        ]);

        $projecttasktype = ProjectTaskType::find($request->input('project_task_type_id'));

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id, '', '', $projecttasktype->user_id);

        $obj = new ProjectTask;
        $obj->project_task_type_id = $request->input('project_task_type_id');
        $obj->project_task_name = $request->input('project_task_name');
        $obj->project_task_deadline = Carbon::createFromFormat('d/m/Y', $request->input('project_task_deadline'))->toDateString();
        $obj->project_task_desc = $request->input('project_task_desc');
        $obj->project_id = $request->input('project_id');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->revision_no = 0;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);
        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = 'uploads/files/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = 'uploads/files/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
            }

            if(File::move($value, $newfile)) {
                $file = pathinfo($newfile);
                $filesize = File::size($newfile);

                $upl = new UploadFile;
                $upl->upload_file_type = $file['extension'];
                $upl->upload_file_name = $file['basename'];
                $upl->upload_file_path = $file['dirname'];
                $upl->upload_file_size = $filesize;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => 0 ];
            }
        }

        if(!empty($fileArray)) {
            ProjectTask::find($obj->project_task_id)->uploadfiles()->sync($fileArray);    
        }

        $his = new ProjectTaskHistory;
        $his->project_task_id = $obj->project_task_id;
        $his->approval_type_id = 1;
        $his->project_task_history_text = $request->input('project_task_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'projecttaskappoval', 'Please check Project Task "' . $obj->project_task_name . '"', $obj->project_task_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('grid/projecttask');
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
