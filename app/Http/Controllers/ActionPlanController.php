<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
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

        $data['mediaeditions'] = MediaEdition::whereIn('media_id', $medias)->where('active', '1')->orderBy('media_edition_no')->get();

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
            'action_plan_type_id' => 'required',
            'action_plan_title' => 'required|max:100',
            'action_plan_startdate' => 'required',
            'action_plan_enddate' => 'required',
            'media_edition_id[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new ActionPlan;
        $obj->action_plan_type_id = $request->input('action_plan_type_id');
        $obj->action_plan_title = $request->input('action_plan_title');
        $obj->action_plan_startdate = Carbon::createFromFormat('d/m/Y', $request->input('action_plan_startdate'))->toDateString();
        $obj->action_plan_enddate = Carbon::createFromFormat('d/m/Y', $request->input('action_plan_enddate'))->toDateString();
        $obj->action_plan_desc = $request->input('action_plan_desc');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $his = new ActionPlanHistory;
        $his->action_plan_id = $obj->action_plan_id;
        $his->action_plan_history_text = $request->input('action_plan_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'actionplanapproval', 'Please check ', $obj->action_plan_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('action_plan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public function apiList(Request $request)
    {
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
        $data['rows'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                            ->where('action_plans.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                        ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = ActionPlan::join('action_types','action_types.action_type_id', '=', 'action_plans.action_type_id')
                            ->where('action_plans.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('action_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('action_plan_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('action_plan_startdate','like','%' . $searchPhrase . '%')
                                        ->orWhere('action_plan_enddate','like','%' . $searchPhrase . '%');
                            })->count();

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
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
