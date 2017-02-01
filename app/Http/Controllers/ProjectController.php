<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use Carbon\Carbon;
use App\Http\Requests;
use App\Client;
use App\Project;
use App\ProjectHistory;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class ProjectController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/grid/project';
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
        if(Gate::denies('Project-Read')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.material.grid.project.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Project-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['pics'] = User::where('active', '1')->whereHas('groups', function($query) {
                            $query->where('group_name', '=', 'GRID - Traffic Control');
                        })->get();

        return view('vendor.material.grid.project.create', $data);
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
            'project_name' => 'required',
            'project_periode_start' => 'required|date_format:"d/m/Y"',
            'project_periode_end' => 'required|date_format:"d/m/Y"',
            'project_desc' => 'required',
            'client_id' => 'required'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id, $request->input('pic'), '', '');

        $obj = new Project;

        $obj->project_code = $this->generateCode();
        $obj->project_name = $request->input('project_name');
        $obj->project_periode_start = Carbon::createFromFormat('d/m/Y', $request->input('project_periode_start'))->toDateString();
        $obj->project_periode_end = Carbon::createFromFormat('d/m/Y', $request->input('project_periode_end'))->toDateString();
        $obj->project_desc = $request->input('project_desc');
        $obj->client_id = $request->input('client_id');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->revision_no = 0;
        $obj->pic = $request->input('pic');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $his = new ProjectHistory;
        $his->project_id = $obj->project_id;
        $his->approval_type_id = 1;
        $his->project_history_text = $request->input('project_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'projectapproval', 'Please check Project "' . $obj->project_ame . '"', $obj->project_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('grid/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Project-Read')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['project'] = Project::with('client')->find($id);
        $data['project_start'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_start==null) ? date('Y-m-d') : $data['project']->project_periode_start)->format('d/m/Y');
        $data['project_end'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_end==null) ? date('Y-m-d') : $data['project']->project_periode_end)->format('d/m/Y');
        
        return view('vendor.material.grid.project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Project-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['project'] = Project::with('client')->find($id);
        $data['project_start'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_start==null) ? date('Y-m-d') : $data['project']->project_periode_start)->format('d/m/Y');
        $data['project_end'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_end==null) ? date('Y-m-d') : $data['project']->project_periode_end)->format('d/m/Y');
        $data['pics'] = User::where('active', '1')->whereHas('groups', function($query) {
                            $query->where('group_name', '=', 'GRID - Traffic Control');
                        })->get();
        
        return view('vendor.material.grid.project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'project_name' => 'required',
            'project_periode_start' => 'required|date_format:"d/m/Y"',
            'project_periode_end' => 'required|date_format:"d/m/Y"',
            'project_desc' => 'required',
            'client_id' => 'required'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id, $request->input('pic'), '', '');

        $obj = Project::find($id);

        $obj->project_name = $request->input('project_name');
        $obj->project_periode_start = Carbon::createFromFormat('d/m/Y', $request->input('project_periode_start'))->toDateString();
        $obj->project_periode_end = Carbon::createFromFormat('d/m/Y', $request->input('project_periode_end'))->toDateString();
        $obj->project_desc = $request->input('project_desc');
        $obj->client_id = $request->input('client_id');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->pic = $request->input('pic');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $his = new ProjectHistory;
        $his->project_id = $obj->project_id;
        $his->approval_type_id = 1;
        $his->project_history_text = $request->input('project_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'projectapproval', $id);
        $this->notif->remove($request->user()->user_id, 'projectreject', $id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'projectapproval', 'Please check Project "' . $obj->project_name . '"', $obj->project_id);

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('grid/project');
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'project_id';
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
            $data['rows'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.current_user')
                                ->where('projects.flow_no','<>','98')
                                ->where('projects.active', '=', '1')
                                ->where('projects.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate)
                                            ->orWhereIn('projects.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.flow_no','<>','98')
                                ->where('projects.active', '=', '1')
                                ->where('projects.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate)
                                            ->orWhereIn('projects.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.active','1')
                                ->where('projects.flow_no','<>','98')
                                ->where('projects.flow_no','<>','99')
                                ->where('projects.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.active','1')
                                ->where('projects.flow_no','<>','98')
                                ->where('projects.flow_no','<>','99')
                                ->where('projects.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.active','1')
                                ->where('projects.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate)
                                            ->orWhere('projects.pic', '=', $request->user()->user_id)
                                            ->orWhereIn('projects.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.active','1')
                                ->where('projects.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate)
                                            ->orWhere('projects.pic', '=', $request->user()->user_id)
                                            ->orWhereIn('projects.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                                ->join('users', 'users.user_id', '=', 'projects.created_by')
                                ->where('projects.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_start','like','%' . $searchPhrase . '%')
                                            ->orWhere('project_periode_end','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Project-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('project_id');

        $obj = Project::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    private function generateCode()
    {
        $total = Project::count();
        $code = 'GRID/PRJ-';

        if($total > 0) {
            $last_row = Project::select('project_id')->orderBy('project_id', 'desc')->first();

            $id = $last_row->project_id + 1;

            if($id >= 10000) {
                $code .= date('y') . $id;
            }elseif($id >= 1000) {
                $code .= date('y') . '0' . $id;
            }elseif($id >= 100) {
                $code .= date('y') . '00' . $id;
            }elseif($id >= 10) {
                $code .= date('y') . '000' . $id;
            }else{
                $code .= date('y') . '0000' . $id;
            }
        }else{
            $code .= date('y') . '00001';
        }

        return $code;

    }

    public function apiSearch(Request $request)
    {
        if(Gate::denies('Home-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $project_name = $request->project_name;

        $result = Project::where('project_name','like','%' . $project_name . '%')->where('active', '1')->take(5)->orderBy('project_name')->get();

        return response()->json($result, 200);
    }

    public function approve(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            return $this->approveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            return $this->approveFlowNo2($request, $id);
        }elseif($flow_no == 3) {
            return $this->approveFlowNo3($request, $id);
        }
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            $this->postApproveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            $this->postApproveFlowNo2($request, $id);
        }elseif($flow_no == 3) {
            $this->postApproveFlowNo3($request, $id);
        }

        return redirect('grid/project');
    }

    private function approveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Project-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['project'] = Project::with('client', 'projecthistories', 'projecthistories.approvaltype')->find($id);
        $data['project_start'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_start==null) ? date('Y-m-d') : $data['project']->project_periode_start)->format('d/m/Y');
        $data['project_end'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_end==null) ? date('Y-m-d') : $data['project']->project_periode_end)->format('d/m/Y');

        $data['url'] = 'grid/project/approve/' . $data['project']->flow_no . '/' . $id;

        return view('vendor.material.grid.project.picform', $data);
    }

    private function postApproveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Project-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'comment' => 'required',
        ]);

        $project = Project::find($id);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, $project->flow_no, $request->user()->user_id, $project->pic, $project->created_by);

        $project->flow_no = $nextFlow['flow_no'];
        $project->current_user = $nextFlow['current_user'];
        $project->project_ready_date = Carbon::now()->toDateTimeString();
        $project->project_delivery_date = Carbon::now()->toDateTimeString();
        $project->updated_by = $request->user()->user_id;
        $project->save();

        $his = new ProjectHistory;
        $his->project_id = $id;
        $his->approval_type_id = 1;
        $his->project_history_text = $request->input('comment');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'projectapproval', $id);
        $this->notif->remove($request->user()->user_id, 'projectreject', $id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'projectapproval', 'Project "' . $project->project_name . '" need approval.', $id);

        $request->session()->flash('status', 'Data has been saved!');

    }

    private function approveFlowNo3(Request $request, $id)
    {
        if(Gate::denies('Project-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['project'] = Project::with('client', 'projecthistories', 'projecthistories.approvaltype')->find($id);
        $data['project_start'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_start==null) ? date('Y-m-d') : $data['project']->project_periode_start)->format('d/m/Y');
        $data['project_end'] = Carbon::createFromFormat('Y-m-d', ($data['project']->project_periode_end==null) ? date('Y-m-d') : $data['project']->project_periode_end)->format('d/m/Y');

        return view('vendor.material.grid.project.approve', $data);
    }

    private function postApproveFlowNo3(Request $request, $id)
    {
        if(Gate::denies('Project-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required',
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $project = Project::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $project->flow_no, $request->user()->user_id, $project->pic, $project->created_by);

            $project->flow_no = $nextFlow['flow_no'];
            $project->current_user = $nextFlow['current_user'];
            $project->updated_by = $request->user()->user_id;
            $project->save();

            $his = new ProjectHistory;
            $his->project_id = $id;
            $his->approval_type_id = 4;
            $his->project_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'projectapproval', $id);
            $this->notif->remove($request->user()->user_id, 'projectreject', $id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'projectfinish', 'Project "' . $project->project_name . '" has been finished.', $id);

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $project = Project::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $project->flow_no, $request->user()->user_id, $project->pic, $project->created_by);

            $project->flow_no = $prevFlow['flow_no'];
            $project->revision_no = $project->revision_no + 1;
            $project->current_user = $prevFlow['current_user'];
            $project->updated_by = $request->user()->user_id;
            $project->save();

            $his = new ProjectHistory;
            $his->project_id = $id;
            $his->approval_type_id = 3;
            $his->project_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'projectapproval', $id);
            $this->notif->remove($request->user()->user_id, 'projectreject', $id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'projectreject', 'Project "' . $project->project_name . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

    }
}
