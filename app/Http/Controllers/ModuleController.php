<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Action;
use App\Module;

class ModuleController extends Controller
{
    protected $searchPhrase = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('vendor.material.master.module.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = array();

        $data['actions'] = Action::where('active','1')->get();

        return view('vendor.material.master.module.create', $data);
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
            'module_url' => 'required|unique:modules,module_url|max:100',
            'action_id[]' => 'array',
        ]);

        $obj = new Module;
        $obj->module_url = $request->input('module_url');
        $obj->module_desc = $request->input('module_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        Module::find($obj->module_id)->actions()->sync($request->input('action_id'));

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/module');
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
        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['module'] = Module::where('active','1')->find($id);
        return view('vendor.material.master.module.show', $data);
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
        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['module'] = Module::where('active','1')->find($id);
        return view('vendor.material.master.module.edit', $data);
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
            'module_url' => 'required|unique:modules,module_url,'.$id.',module_id|max:100',
            'action_id[]' => 'array',
        ]);

        $obj = Module::find($id);
        $obj->module_url = $request->input('module_url');
        $obj->module_desc = $request->input('module_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        Module::find($obj->module_id)->actions()->sync($request->input('action_id'));

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/module');
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
        $this->searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'module_id';
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
        $data['searchPhrase'] = $this->searchPhrase;
        $data['rows'] = Module::where('active','1')
                            ->where(function($query) {
                                $query->where('module_url','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('module_desc','like','%' . $this->searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Module::where('active','1')
                                ->where(function($query) {
                                    $query->where('module_url','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('module_desc','like','%' . $this->searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('module_id');

        $obj = Module::find($id);

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
