<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Action;
use App\Menu;
use App\Role;
use App\RoleLevel;
use App\RolesModules;

use DB;
use App\Ibrol\Libraries\MenuLibrary;
use App\Ibrol\Libraries\Recursive;

class RoleController extends Controller
{
    protected $menulibrary;

    public function __construct(){
        $this->menulibrary = new MenuLibrary;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Gate::denies('Roles Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

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
        if(Gate::denies('Roles Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['rolelevels'] = RoleLevel::where('active','1')->get();
        $data['menus'] = $this->menulibrary->generateListModule();
        return view('vendor.material.master.role.create', $data);
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
        //dd($request->input('module_id'));

        $module_access = $request->input('module_id');

        $this->validate($request, [
            'role_level_id' => 'required',
            'role_name' => 'required|max:100',
            'role_desc' => 'required',
        ]);

        $role = new Role;

        $role->role_level_id = $request->input('role_level_id');
        $role->role_name = $request->input('role_name');
        $role->role_desc = $request->input('role_desc');
        $role->active = '1';
        $role->created_by = $request->user()->user_id;

        $role->save();

        foreach ($module_access as $key => $value) {
            foreach ($value as $k => $v) {
                $rolesmodules = new RolesModules;
                $rolesmodules->role_id = $role->role_id;
                $rolesmodules->module_id = $key;
                $rolesmodules->action_id = $k;
                $rolesmodules->access = $v;

                $rolesmodules->save();
                /*echo 'module_id' . $key . '<br/>';
                echo 'action_id' . $k . '<br/>';*/
            }
        }

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
        if(Gate::denies('Roles Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['role'] = Role::where('active','1')->find($id);
        $data['rolelevels'] = RoleLevel::where('active','1')->get();
        $data['menus'] = $this->menulibrary->generateListModule();
        $data['rolesmodules'] = RolesModules::where('role_id', $id)->get();
        return view('vendor.material.master.role.show', $data);
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
        if(Gate::denies('Roles Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $module = $this->menulibrary->generateListModule();

        $data = array();
        $data['actions'] = Action::where('active','1')->get();
        $data['rolelevels'] = RoleLevel::where('active','1')->get();
        $data['role'] = Role::where('active','1')->find($id);
        $data['menus'] = $this->menulibrary->generateListModule();
        $data['rolesmodules'] = RolesModules::where('role_id', $id)->get();

        //dd(count($data['rolesmodules']->where('module_id', '4')->where('action_id', '2')));
        /*dd($data['rolesmodules']);*/
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
        $module_access = $request->input('module_id');

        $this->validate($request, [
            'role_level_id' => 'required',
            'role_name' => 'required|max:100',
            'role_desc' => 'required',
        ]);

        $role = Role::find($id);

        $role->role_level_id = $request->input('role_level_id');
        $role->role_name = $request->input('role_name');
        $role->role_desc = $request->input('role_desc');
        $role->updated_by = $request->user()->user_id;

        $role->save();

        //delete roles modules
        $rm = RolesModules::where('role_id', $id)->delete();

        foreach ($module_access as $key => $value) {
            foreach ($value as $k => $v) {
                $rolesmodules = new RolesModules;
                $rolesmodules->role_id = $id;
                $rolesmodules->module_id = $key;
                $rolesmodules->action_id = $k;
                $rolesmodules->access = $v;

                $rolesmodules->save();
            }
        }

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
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
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
        $data['current'] = intval($current);
        $data['rowCount'] = $rowCount;
        $data['searchPhrase'] = $searchPhrase;
        $data['rows'] = Role::join('role_levels', 'role_levels.role_level_id', '=', 'roles.role_level_id')
                            ->where('roles.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('role_level_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('role_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('role_desc','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Role::join('role_levels', 'role_levels.role_level_id', '=', 'roles.role_level_id')
                                ->where('roles.active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('role_level_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('role_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('role_desc','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }

    public function apiEdit(Request $request)
    {
        if(Gate::denies('Roles Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $role_id = $request->input('role_id');

        $role = Role::find($role_id);

        $role->active = '0';
        $role->updated_by = $request->user()->user_id;

        if($role->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
