<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use Carbon\Carbon;
use App\Http\Requests;
use App\Client;
use App\Project;

use App\Ibrol\Libraries\UserLibrary;

class ProjectController extends Controller
{
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
            'project_desc' => 'required',
            'client_id' => 'required'
        ]);

        $obj = new Project;

        $obj->project_code = $this->generateCode();
        $obj->project_name = $request->input('project_name');
        $obj->project_desc = $request->input('project_desc');
        $obj->client_id = $request->input('client_id');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

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
            'project_desc' => 'required',
            'client_id' => 'required'
        ]);

        $obj = Project::find($id);

        $obj->project_name = $request->input('project_name');
        $obj->project_desc = $request->input('project_desc');
        $obj->client_id = $request->input('client_id');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('grid/project');
    }

    public function apiList(Request $request)
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
        $data['rows'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                            ->join('users', 'users.user_id', '=', 'projects.created_by')
                            ->where('projects.active','1')
                            ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate);
                                })
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Project::join('clients', 'clients.client_id', '=', 'projects.client_id')
                            ->join('users', 'users.user_id', '=', 'projects.created_by')
                            ->where('projects.active','1')
                            ->where(function($query) use($request, $subordinate){
                                    $query->where('projects.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('projects.created_by', $subordinate);
                                })
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('project_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('project_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                            })->count();

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
}
