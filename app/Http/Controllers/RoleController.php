<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Role;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('vendor.material.master.role.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vendor.material.master.role.create');
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
            'role_name' => 'required|max:100',
            'role_desc' => 'required',
        ]);

        $role = new Role;

        $role->role_name = $request->input('role_name');
        $role->role_desc = $request->input('role_desc');
        $role->active = '1';
        $role->created_by = $request->user()->user_id;

        $role->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/role');
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
        $data = array();
        $data['role'] = Role::where('active','1')->find($id);
        return view('vendor.material.master.role.edit', $data);
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
            'role_name' => 'required|max:100',
            'role_desc' => 'required',
        ]);

        $role = Role::find($id);

        $role->role_name = $request->input('role_name');
        $role->role_desc = $request->input('role_desc');
        $role->updated_by = $request->user()->user_id;

        $role->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/role');
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
        //$sort = $request->input('sort.role_name') or 'asc';
        $sort_column = 'role_id';
        $sort_type = 'asc';

        if(is_array($request->input('sort'))) {
            foreach($request->input('sort') as $key => $value)
            {
                $sort_column = $key;
                $sort_type = $value;
            }
        }

        $data = array();
        $data['current'] = $current;
        $data['rowCount'] = $rowCount;
        $data['searchPhrase'] = $searchPhrase;

        //$data['rows'] = Role::getApiList($current,$rowCount,$searchPhrase)->get();
        //$data['rows'] = DB::table('roles')->where('active','1')->where('role_name','like','%$searchPhrase%')->skip($current)->take($rowCount)->get();
        $data['rows'] = Role::where('active','1')
                            ->where('role_name','like','%' . $searchPhrase . '%')
                            ->orWhere('role_desc','like','%' . $searchPhrase . '%')
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        //dd($data['rows']);
        $data['total'] = Role::where('active','1')->count();

        //return $data->toJson();
        return response()->json($data);
    }
}
