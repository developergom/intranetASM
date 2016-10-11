<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use BrowserDetect;
use App\Http\Requests;
use App\ActionPlan;
use App\ActionPlanHistory;
use App\UploadFile;
use App\ActionType;
use App\Media;
use App\MediaEdition;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class ActionPlanController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/plan/actionplan';
    private $notif;

    public function __construct() {
        $flow = new FlowLibrary;
        $this->flows = $flow->getCurrentFlows($this->uri);
        $this->flow_group_id = $this->flows[0]->flow_group_id;

        $this->notif = new NotificationLibrary;
        //dd();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Action Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        //dd($this->flows);

        $data = array();

        return view('vendor.material.plan.actionplan.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*$flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        dd($nextFlow);*/

        if(Gate::denies('Action Plan-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['actiontypes'] = ActionType::where('active', '1')->orderBy('action_type_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        /*$m = MediaEdition::whereHas('media', function($query) use($data){
            $query->where('mediaeditions.media_id', '=', $data['medias']);
        })->where('mediaeditions.active', '1')->orderBy('media_edition_no')->get();*/
        /*$m = MediaEdition::where('mediaeditions.media_id', 'IN', $data['medias'])->where('mediaeditions.active', '1')->orderBy('media_edition_no')->get();*/


        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }
        /*dd($medias);*/

        $data['mediaeditions'] = MediaEdition::with('media')->whereIn('media_id', $medias)->where('active', '1')->orderBy('media_edition_no')->get();

        return view('vendor.material.plan.actionplan.create', $data);
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
            'action_type_id' => 'required',
            'action_plan_title' => 'required|max:100',
            'action_plan_startdate' => 'required|date_format:"d/m/Y"',
            'action_plan_enddate' => 'required|date_format:"d/m/Y"',
            'media_edition_id[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new ActionPlan;
        $obj->action_type_id = $request->input('action_type_id');
        $obj->action_plan_title = $request->input('action_plan_title');
        $obj->action_plan_startdate = Carbon::createFromFormat('d/m/Y', $request->input('action_plan_startdate'))->toDateString();
        $obj->action_plan_enddate = Carbon::createFromFormat('d/m/Y', $request->input('action_plan_enddate'))->toDateString();
        $obj->action_plan_desc = $request->input('action_plan_desc');
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
            ActionPlan::find($obj->action_plan_id)->uploadfiles()->sync($fileArray);    
        }

        if(!empty($request->input('media_id'))) {
            ActionPlan::find($obj->action_plan_id)->medias()->sync($request->input('media_id'));
        }
        
        if(!empty($request->input('media_edition_id'))) {
            ActionPlan::find($obj->action_plan_id)->mediaeditions()->sync($request->input('media_edition_id'));
        }

        $his = new ActionPlanHistory;
        $his->action_plan_id = $obj->action_plan_id;
        $his->approval_type_id = 1;
        $his->action_plan_history_text = $request->input('action_plan_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'actionplanapproval', 'Please check Action Plan "' . $obj->action_plan_title . '"', $obj->action_plan_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('plan/actionplan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(Gate::denies('Action Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['actionplan'] = ActionPlan::with('actionplanhistories', 'actionplanhistories.approvaltype')->find($id);

        $data['actiontypes'] = ActionType::where('active', '1')->orderBy('action_type_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['mediaeditions'] = MediaEdition::with('media')->whereIn('media_id', $medias)->where('active', '1')->orderBy('media_edition_no')->get();
        $startdate = Carbon::createFromFormat('Y-m-d', ($data['actionplan']->action_plan_startdate==null) ? date('Y-m-d') : $data['actionplan']->action_plan_startdate);
        $enddate = Carbon::createFromFormat('Y-m-d', ($data['actionplan']->action_plan_enddate==null) ? date('Y-m-d') : $data['actionplan']->action_plan_enddate);
        $data['startdate'] = $startdate->format('d/m/Y');
        $data['enddate'] = $enddate->format('d/m/Y');
        $data['uploadedfiles'] = $data['actionplan']->uploadfiles()->where('revision_no', $data['actionplan']->revision_no)->get();

        return view('vendor.material.plan.actionplan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(Gate::denies('Action Plan-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['actionplan'] = ActionPlan::find($id);

        $data['actiontypes'] = ActionType::where('active', '1')->orderBy('action_type_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['mediaeditions'] = MediaEdition::with('media')->whereIn('media_id', $medias)->where('active', '1')->orderBy('media_edition_no')->get();
        $startdate = Carbon::createFromFormat('Y-m-d', ($data['actionplan']->action_plan_startdate==null) ? date('Y-m-d') : $data['actionplan']->action_plan_startdate);
        $enddate = Carbon::createFromFormat('Y-m-d', ($data['actionplan']->action_plan_enddate==null) ? date('Y-m-d') : $data['actionplan']->action_plan_enddate);
        $data['startdate'] = $startdate->format('d/m/Y');
        $data['enddate'] = $enddate->format('d/m/Y');
        $data['uploadedfiles'] = $data['actionplan']->uploadfiles()->where('revision_no', $data['actionplan']->revision_no)->get();

        return view('vendor.material.plan.actionplan.edit', $data);
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
            'action_type_id' => 'required',
            'action_plan_title' => 'required|max:100',
            'action_plan_startdate' => 'required|date_format:"d/m/Y"',
            'action_plan_enddate' => 'required|date_format:"d/m/Y"',
            'media_edition_id[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = ActionPlan::find($id);
        $obj->action_type_id = $request->input('action_type_id');
        $obj->action_plan_title = $request->input('action_plan_title');
        $obj->action_plan_startdate = Carbon::createFromFormat('d/m/Y', $request->input('action_plan_startdate'))->toDateString();
        $obj->action_plan_enddate = Carbon::createFromFormat('d/m/Y', $request->input('action_plan_enddate'))->toDateString();
        $obj->action_plan_desc = $request->input('action_plan_desc');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->updated_by = $request->user()->user_id;

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
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $obj->revision_no ];
            }
        }

        if(!empty($fileArray)) {
            ActionPlan::find($obj->action_plan_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        if(!empty($request->input('media_id'))) {
            ActionPlan::find($obj->action_plan_id)->medias()->sync($request->input('media_id'));
        }
        
        if(!empty($request->input('media_edition_id'))) {
            ActionPlan::find($obj->action_plan_id)->mediaeditions()->sync($request->input('media_edition_id'));
        }

        $his = new ActionPlanHistory;
        $his->action_plan_id = $obj->action_plan_id;
        $his->approval_type_id = 1;
        $his->action_plan_history_text = $request->input('action_plan_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'actionplanreject', $obj->action_plan_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'actionplanapproval', 'Please check Action Plan "' . $obj->action_plan_title . '"', $obj->action_plan_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('plan/actionplan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        //dd($subordinate);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'action_plan_id';
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
            $data['rows'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.current_user')
                                ->where('action_plans.flow_no','<>','98')
                                ->where('action_plans.active', '=', '1')
                                ->where('action_plans.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('action_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('action_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.current_user')
                                ->where('action_plans.flow_no','<>','98')
                                ->where('action_plans.active', '=', '1')
                                ->where('action_plans.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('action_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('action_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.created_by')
                                ->where('action_plans.active','1')
                                ->where('action_plans.flow_no','<>','98')
                                ->where('action_plans.flow_no','<>','99')
                                ->where('action_plans.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.created_by')
                                ->where('action_plans.active','1')
                                ->where('action_plans.flow_no','<>','98')
                                ->where('action_plans.flow_no','<>','99')
                                ->where('action_plans.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.created_by')
                                ->where('action_plans.active','1')
                                ->where('action_plans.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('action_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('action_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.created_by')
                                ->where('action_plans.active','1')
                                ->where('action_plans.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('action_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('action_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.created_by')
                                ->where('action_plans.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('action_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('action_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                                ->join('users','users.user_id', '=', 'action_plans.created_by')
                                ->where('action_plans.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('action_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('action_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                            ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Action Plan-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('action_plan_id');

        $obj = ActionPlan::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            $his = new ActionPlanHistory;
            $his->action_plan_id = $id;
            $his->approval_type_id = 3;
            $his->action_plan_history_text = 'Deleting';
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'actionplanreject', $obj->action_plan_id);
            $this->notif->remove($request->user()->user_id, 'actionplanapproval', $obj->action_plan_id);
            $this->notif->remove($request->user()->user_id, 'actionplanfinished', $obj->action_plan_id);

            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function approve(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            return $this->approveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            return $this->approveFlowNo2($request, $id);
        }
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            $this->postApproveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            $this->postApproveFlowNo2($request, $id);
        }

        return redirect('plan/actionplan');
    }

    private function approveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Action Plan-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['actionplan'] = ActionPlan::find($id);

        $data['actiontypes'] = ActionType::where('active', '1')->orderBy('action_type_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['mediaeditions'] = MediaEdition::whereIn('media_id', $medias)->where('active', '1')->orderBy('media_edition_no')->get();
        $startdate = Carbon::createFromFormat('Y-m-d', ($data['actionplan']->action_plan_startdate==null) ? date('Y-m-d') : $data['actionplan']->action_plan_startdate);
        $enddate = Carbon::createFromFormat('Y-m-d', ($data['actionplan']->action_plan_enddate==null) ? date('Y-m-d') : $data['actionplan']->action_plan_enddate);
        $data['startdate'] = $startdate->format('d/m/Y');
        $data['enddate'] = $enddate->format('d/m/Y');
        $data['uploadedfiles'] = $data['actionplan']->uploadfiles()->where('revision_no', $data['actionplan']->revision_no)->get();

        return view('vendor.material.plan.actionplan.approve', $data);
    }

    private function postApproveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Action Plan-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required',
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $actionplan = ActionPlan::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $actionplan->flow_no, $request->user()->user_id, '', $actionplan->created_by->user_id);

            //dd($nextFlow);

            $actionplan->flow_no = $nextFlow['flow_no'];
            $actionplan->current_user = $nextFlow['current_user'];
            $actionplan->updated_by = $request->user()->user_id;
            $actionplan->save();

            $his = new ActionPlanHistory;
            $his->action_plan_id = $id;
            $his->approval_type_id = 2;
            $his->action_plan_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'actionplanapproval', $actionplan->action_plan_id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'actionplanfinished', 'Action Plan "' . $actionplan->action_plan_title . '" has been approved.', $id);

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $actionplan = ActionPlan::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $actionplan->flow_no, $request->user()->user_id, '', $actionplan->created_by->user_id);

            //dd($prevFlow);

            $actionplan->flow_no = $prevFlow['flow_no'];
            $actionplan->revision_no = $actionplan->revision_no + 1;
            $actionplan->current_user = $prevFlow['current_user'];
            $actionplan->updated_by = $request->user()->user_id;
            $actionplan->save();

            $his = new ActionPlanHistory;
            $his->action_plan_id = $id;
            $his->approval_type_id = 3;
            $his->action_plan_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'actionplanapproval', $actionplan->action_plan_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'actionplanreject', 'Action Plan "' . $actionplan->action_plan_title . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

    }
}
