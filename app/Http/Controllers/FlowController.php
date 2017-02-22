<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Flow;
use App\FlowGroup;
use App\Role;

class FlowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Flows Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.flow.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Flows Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['flowbyitems'] = $this->getFlowByItems();
        $data['flowgroup'] = FlowGroup::where('active','1')->orderBy('flow_group_name')->get();
        $data['role'] = Role::where('active','1')->orderBy('role_name')->get();

        return view('vendor.material.master.flow.create', $data);
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
            'flow_group_id' => 'required',
            'flow_name' => 'required|max:100',
            'flow_url' => 'required|max:255',
            'flow_no' => 'required',
            'flow_prev' => 'required',
            'flow_by' => 'required',
            'role_id' => 'required'
        ]);

        //reorder flow
        $this->reorderFlow($request, 'ADD', $request->input('flow_group_id'), $request->input('flow_no'));

        $obj = new Flow;
        $obj->flow_group_id = $request->input('flow_group_id');
        $obj->flow_name = $request->input('flow_name');
        $obj->flow_url = $request->input('flow_url');
        $obj->flow_no = $request->input('flow_no');
        $obj->flow_prev = $request->input('flow_prev');
        $obj->flow_next = $request->input('flow_no') + 1;
        $obj->flow_by = $request->input('flow_by');
        $obj->role_id = $request->input('role_id');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/flow');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Flows Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['flow'] = Flow::find($id);
        $data['flowbyitems'] = $this->getFlowByItems();
        $data['flowgroup'] = FlowGroup::where('active','1')->orderBy('flow_group_name')->get();
        $data['role'] = Role::where('active','1')->orderBy('role_name')->get();

        return view('vendor.material.master.flow.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Flows Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['flow'] = Flow::find($id);
        $data['flowbyitems'] = $this->getFlowByItems();
        $data['flowgroup'] = FlowGroup::where('active','1')->orderBy('flow_group_name')->get();
        $data['role'] = Role::where('active','1')->orderBy('role_name')->get();
        $data['count'] = Flow::where('active', '1')->where('flow_group_id', $data['flow']->flow_group_id)->count();

        return view('vendor.material.master.flow.edit', $data);
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
            'flow_group_id' => 'required',
            'flow_name' => 'required|max:100',
            'flow_url' => 'required|max:255',
            'flow_no' => 'required',
            'flow_prev' => 'required',
            'flow_by' => 'required',
            'role_id' => 'required'
        ]);

        $obj = Flow::find($id);

        //reorder flow
        if($request->input('flow_no') > $obj->flow_no)
        {
            $direction = 'TOUPPER';
        }
        else
        {
            $direction = 'TOLOWER';
        }

        $this->reorderFlow($request, 'UPDATE', $request->input('flow_group_id'), $request->input('flow_no'), $direction, $obj->flow_no);

        $obj->flow_group_id = $request->input('flow_group_id');
        $obj->flow_name = $request->input('flow_name');
        $obj->flow_url = $request->input('flow_url');
        $obj->flow_no = $request->input('flow_no');
        $obj->flow_prev = $request->input('flow_prev');
        $obj->flow_next = $request->input('flow_no') + 1;
        $obj->flow_by = $request->input('flow_by');
        $obj->role_id = $request->input('role_id');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/flow');
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
        
        $sort_column = 'flow_id';
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
        $data['rows'] = Flow::join('flow_groups','flow_groups.flow_group_id','=','flows.flow_group_id')
        					->join('roles','roles.role_id','=','flows.role_id')
                            ->where('flows.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('flow_group_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_no','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_by','like','%' . $searchPhrase . '%')
                                        ->orWhere('role_name','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Flow::join('flow_groups','flow_groups.flow_group_id','=','flows.flow_group_id')
        					->join('roles','roles.role_id','=','flows.role_id')
                            ->where('flows.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('flow_group_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_no','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_by','like','%' . $searchPhrase . '%')
                                        ->orWhere('role_name','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Flows Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('flow_id');

        $obj = Flow::find($id);

        //reorder flow
        $this->reorderFlow($request, 'DELETE', $obj->flow_group_id, $obj->flow_no);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    /**
    * 
    * @param int flow_group_id
    *
    * @return json
    *
    **/
    public function apiCountFlow(Request $request)
    {
        $result = array();

        $result['count'] = Flow::where('active', '1')->where('flow_group_id', $request->input('flow_group_id'))->count();

        return response()->json($result);
    }

    public function getFlowByItems()
    {
    	$flow = new Flow;
    	//dd($flow->flowbyitems);
    	return $flow->flowbyitems;
    }

    /**
    * 
    * @param string $method (ADD, UPDATE, DELETE)
    * @param int $flow_group_id
    * @param int $order
    *
    * @return void()
    **/
    private function reorderFlow(Request $request, $method, $flow_group_id, $order, $direction = NULL, $old_order = NULL)
    {
        if($method == 'ADD')
        {
            $flows = Flow::where('active','1')->where('flow_group_id', $flow_group_id)->where('flow_no', '>=', $order)->get();

            foreach($flows as $flow)
            {
                $update = Flow::find($flow->flow_id);
                $update->flow_no = $flow->flow_no + 1;
                $update->updated_by = $request->user()->user_id;
                $update->save();
            }
        }elseif($method == 'UPDATE'){
            if($direction == 'TOLOWER')
            {
                $flows = Flow::where('active','1')->where('flow_group_id', $flow_group_id)->where('flow_no', '>', $order)->where('flow_no', '<=', $old_order)->get();

                foreach($flows as $flow)
                {
                    $update = Flow::find($flow->flow_id);
                    $update->flow_no = $flow->flow_no + 1;
                    $update->updated_by = $request->user()->user_id;
                    $update->save();
                }
            }
            elseif($direction == 'TOUPPER')
            {
                $flows = Flow::where('active','1')->where('flow_group_id', $flow_group_id)->where('flow_no', '>=', $order)->where('flow_no', '>=', $old_order)->get();

                foreach($flows as $flow)
                {
                    $update = Flow::find($flow->flow_id);
                    $update->flow_no = $flow->flow_no - 1;
                    $update->updated_by = $request->user()->user_id;
                    $update->save();
                }
            }
        }elseif($method == 'DELETE'){
            $flows = Flow::where('active','1')->where('flow_group_id', $flow_group_id)->where('flow_no', '>', $order)->get();

            foreach($flows as $flow)
            {
                $update = Flow::find($flow->flow_id);
                $update->flow_no = $flow->flow_no - 1;
                $update->updated_by = $request->user()->user_id;
                $update->save();
            }
        }
    }
}
