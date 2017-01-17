<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use BrowserDetect;
use App\Http\Requests;
use App\EventPlan;
use App\EventPlanHistory;
use App\UploadFile;
use App\EventType;
use App\Implementation;
use App\Location;
use App\Media;
use App\MediaEdition;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class EventPlanController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/plan/eventplan';
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
        if(Gate::denies('Program Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.plan.eventplan.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Gate::denies('Program Plan-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['eventtypes'] = EventType::where('active', '1')->orderBy('event_type_name')->get();
        $data['locations'] = Location::where('active', '1')->orderBy('location_name')->get();
        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        return view('vendor.material.plan.eventplan.create', $data);
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
            'event_type_id' => 'required',
            'event_plan_name' => 'required|max:100',
            'event_plan_desc' => 'required',
            'event_plan_viewer' => 'required|numeric',
            'location_id' => 'required',
            'event_plan_year' => 'required|max:4',
            'event_plan_deadline' => 'required|date_format:"d/m/Y"',
            'implementation_id[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new EventPlan;
        $obj->event_type_id = $request->input('event_type_id');
        $obj->event_plan_name = $request->input('event_plan_name');
        $obj->event_plan_desc = $request->input('event_plan_desc');
        $obj->event_plan_viewer = $request->input('event_plan_viewer');
        $obj->location_id = $request->input('location_id');
        $obj->event_plan_year = $request->input('event_plan_year');
        $obj->event_plan_deadline = Carbon::createFromFormat('d/m/Y', $request->input('event_plan_deadline'))->toDateString();
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
            EventPlan::find($obj->event_plan_id)->uploadfiles()->sync($fileArray);    
        }

        if(!empty($request->input('media_id'))) {
            EventPlan::find($obj->event_plan_id)->medias()->sync($request->input('media_id'));
        }
        
        if(!empty($request->input('implementation_id'))) {
            EventPlan::find($obj->event_plan_id)->implementations()->sync($request->input('implementation_id'));
        }

        $his = new EventPlanHistory;
        $his->event_plan_id = $obj->event_plan_id;
        $his->approval_type_id = 1;
        $his->event_plan_history_text = $request->input('event_plan_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'eventplanapproval', 'Please check Program Plan "' . $obj->event_plan_name . '"', $obj->event_plan_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('plan/eventplan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(Gate::denies('Program Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['eventplan'] = EventPlan::with('eventtype', 'eventplanhistories', 'eventplanhistories.approvaltype')->find($id);

        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();

        $event_plan_deadline = Carbon::createFromFormat('Y-m-d', ($data['eventplan']->event_plan_deadline==null) ? date('Y-m-d') : $data['eventplan']->event_plan_deadline);
        $data['event_plan_deadline'] = $event_plan_deadline->format('d/m/Y');
        $data['uploadedfiles'] = $data['eventplan']->uploadfiles()->where('revision_no', $data['eventplan']->revision_no)->get();

        return view('vendor.material.plan.eventplan.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(Gate::denies('Program Plan-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['eventplan'] = EventPlan::with('eventtype', 'medias', 'eventplanhistories', 'eventplanhistories.approvaltype')->find($id);
        $data['eventtypes'] = EventType::where('active', '1')->orderBy('event_type_name')->get();
        $data['locations'] = Location::where('active', '1')->orderBy('location_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();

        $event_plan_deadline = Carbon::createFromFormat('Y-m-d', ($data['eventplan']->event_plan_deadline==null) ? date('Y-m-d') : $data['eventplan']->event_plan_deadline);
        $data['event_plan_deadline'] = $event_plan_deadline->format('d/m/Y');
        $data['uploadedfiles'] = $data['eventplan']->uploadfiles()->where('revision_no', $data['eventplan']->revision_no)->get();

        return view('vendor.material.plan.eventplan.edit', $data);
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
            'event_type_id' => 'required',
            'event_plan_name' => 'required|max:100',
            'event_plan_desc' => 'required',
            'event_plan_viewer' => 'required|numeric',
            'location_id' => 'required',
            'event_plan_year' => 'required|max:4',
            'event_plan_deadline' => 'required|date_format:"d/m/Y"',
            'implementation_id[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = EventPlan::find($id);
        $obj->event_type_id = $request->input('event_type_id');
        $obj->event_plan_name = $request->input('event_plan_name');
        $obj->event_plan_desc = $request->input('event_plan_desc');
        $obj->event_plan_viewer = $request->input('event_plan_viewer');
        $obj->location_id = $request->input('location_id');
        $obj->event_plan_year = $request->input('event_plan_year');
        $obj->event_plan_deadline = Carbon::createFromFormat('d/m/Y', $request->input('event_plan_deadline'))->toDateString();
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
            EventPlan::find($obj->event_plan_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        if(!empty($request->input('media_id'))) {
            EventPlan::find($obj->event_plan_id)->medias()->sync($request->input('media_id'));
        }
        
        if(!empty($request->input('implementation_id'))) {
            EventPlan::find($obj->event_plan_id)->implementations()->sync($request->input('implementation_id'));
        }

        $his = new EventPlanHistory;
        $his->event_plan_id = $obj->event_plan_id;
        $his->approval_type_id = 1;
        $his->event_plan_history_text = $request->input('event_plan_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'eventplanreject', $obj->event_plan_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'eventplanapproval', 'Please check Program Plan "' . $obj->event_plan_name . '"', $obj->event_plan_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('plan/eventplan');
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'event_plan_id';
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
            $data['rows'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.flow_no','<>','98')
                                ->where('event_plans.active', '=', '1')
                                ->where('event_plans.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('event_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('event_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.flow_no','<>','98')
                                ->where('event_plans.active', '=', '1')
                                ->where('event_plans.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('event_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('event_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'needchecking') {
            $data['rows'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.active','1')
                                ->where('event_plans.flow_no','<>','98')
                                ->where('event_plans.flow_no','<>','99')
                                ->where('event_plans.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.active','1')
                                ->where('event_plans.flow_no','<>','98')
                                ->where('event_plans.flow_no','<>','99')
                                ->where('event_plans.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.active','1')
                                ->where('event_plans.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('event_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('event_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.active','1')
                                ->where('event_plans.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('event_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('event_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('event_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('event_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = EventPlan::join('event_types','event_types.event_type_id', '=', 'event_plans.event_type_id')
            					->join('event_plans_implementations','event_plans_implementations.event_plan_id', '=', 'event_plans.event_plan_id')
            					->join('implementations','implementations.implementation_id', '=', 'event_plans_implementations.implementation_id')
                                ->join('users','users.user_id', '=', 'event_plans.current_user')
                                ->where('event_plans.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('event_plans.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('event_plans.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('event_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_viewer','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('event_plan_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }
        

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Program Plan-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('event_plan_id');

        $obj = EventPlan::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            $his = new EventPlanHistory;
            $his->event_plan_id = $id;
            $his->approval_type_id = 3;
            $his->event_plan_history_text = 'Deleting';
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'eventplanreject', $obj->event_plan_id);
            $this->notif->remove($request->user()->user_id, 'eventplanapproval', $obj->event_plan_id);
            $this->notif->remove($request->user()->user_id, 'eventplanfinished', $obj->event_plan_id);

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

        return redirect('plan/eventplan');
    }

    private function approveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Program Plan-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['eventplan'] = EventPlan::with('eventtype', 'eventplanhistories', 'eventplanhistories.approvaltype')->find($id);

        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();

        $event_plan_deadline = Carbon::createFromFormat('Y-m-d', ($data['eventplan']->event_plan_deadline==null) ? date('Y-m-d') : $data['eventplan']->event_plan_deadline);
        $data['event_plan_deadline'] = $event_plan_deadline->format('d/m/Y');
        $data['uploadedfiles'] = $data['eventplan']->uploadfiles()->where('revision_no', $data['eventplan']->revision_no)->get();

        return view('vendor.material.plan.eventplan.approve', $data);
    }

    private function postApproveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Program Plan-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required',
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $eventplan = EventPlan::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $eventplan->flow_no, $request->user()->user_id, '', $eventplan->created_by->user_id);

            $eventplan->flow_no = $nextFlow['flow_no'];
            $eventplan->current_user = $nextFlow['current_user'];
            $eventplan->updated_by = $request->user()->user_id;
            $eventplan->save();

            $his = new EventPlanHistory;
            $his->event_plan_id = $id;
            $his->approval_type_id = 2;
            $his->event_plan_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'eventplanapproval', $eventplan->event_plan_id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'eventplanfinished', 'Program Plan "' . $eventplan->event_plan_name . '" has been approved.', $id);

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $eventplan = EventPlan::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $eventplan->flow_no, $request->user()->user_id, '', $eventplan->created_by->user_id);

            $eventplan->flow_no = $prevFlow['flow_no'];
            $eventplan->revision_no = $eventplan->revision_no + 1;
            $eventplan->current_user = $prevFlow['current_user'];
            $eventplan->updated_by = $request->user()->user_id;
            $eventplan->save();

            $his = new EventPlanHistory;
            $his->event_plan_id = $id;
            $his->approval_type_id = 3;
            $his->event_plan_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'eventplanapproval', $eventplan->event_plan_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'eventplanreject', 'Program Plan "' . $eventplan->event_plan_name . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

    }


    public function apiSearch(Request $request)
    {
        if(Gate::denies('Home-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $event_plan_name = $request->event_plan_name;

        $result = EventPlan::where('event_plan_name','like','%' . $event_plan_name . '%')->where('active', '1')->take(5)->orderBy('event_plan_name')->get();

        return response()->json($result, 200);
    }
}
