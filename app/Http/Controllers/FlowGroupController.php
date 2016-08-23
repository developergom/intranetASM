<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\FlowGroup;
use App\Module;

class FlowGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Gate::denies('Flow Groups Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.flowgroup.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Gate::denies('Flow Groups Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['modules'] = Module::where('active','1')->orderBy('module_url')->get();

        return view('vendor.material.master.flowgroup.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'flow_group_name' => 'required|max:100',
            'module_id' => 'required|unique:flow_groups,module_id',
        ]);

        $obj = new FlowGroup;
        $obj->flow_group_name = $request->input('flow_group_name');
        $obj->module_id = $request->input('module_id');
        $obj->flow_group_desc = $request->input('flow_group_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/flowgroup');
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
        if(Gate::denies('Flow Groups Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['flowgroup'] = FlowGroup::find($id);
        $data['modules'] = Module::where('active','1')->get();

        return view('vendor.material.master.flowgroup.show', $data);
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
        if(Gate::denies('Flow Groups Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['flowgroup'] = FlowGroup::find($id);
        $data['modules'] = Module::where('active','1')->orderBy('module_url')->get();

        return view('vendor.material.master.flowgroup.edit', $data);
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
        $this->validate($request, [
            'flow_group_name' => 'required|max:100',
            'module_id' => 'required|unique:flow_groups,module_id,'.$id.',flow_group_id',
        ]);


        $obj = FlowGroup::find($id);

        $obj->flow_group_name = $request->input('flow_group_name');
        $obj->module_id = $request->input('module_id');
        $obj->flow_group_desc = $request->input('flow_group_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/flowgroup');
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
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'flow_group_id';
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
        $data['rows'] = FlowGroup::join('modules','modules.module_id','=','flow_groups.module_id')
                            ->where('flow_groups.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('flow_group_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('module_url','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_group_desc','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = FlowGroup::join('modules','modules.module_id','=','flow_groups.module_id')
                                ->where('flow_groups.active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('flow_group_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('module_url','like','%' . $searchPhrase . '%')
                                        ->orWhere('flow_group_desc','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Flow Groups Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('flow_group_id');

        $obj = FlowGroup::find($id);

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
