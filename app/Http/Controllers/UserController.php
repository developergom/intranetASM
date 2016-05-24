<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\User;
use App\Religion;
use App\Role;

class UserController extends Controller
{
    protected $searchPhrase;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('vendor.material.user.list');
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
        $data['religion'] = Religion::where('active','1')->get();
        $data['roles'] = Role::where('active','1')->get();

        return view('vendor.material.user.create', $data);
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
            'user_name' => 'required|unique:users,user_name|max:100|min:6',
            'user_firstname' => 'required|max:100',
            'user_birthdate' => 'required',
            'user_gender' => 'required',
            'religion_id' => 'required',
            'user_email' => 'required|unique:users,user_email|max:100',
            'user_phone' => 'digits_between:10, 14',
            'role_id[]' => 'array',
        ]);

        //dd($request->all());

        $obj = new User;
        $obj->user_name = $request->input('user_name');
        $obj->user_firstname = $request->input('user_firstname');
        $obj->user_lastname = $request->input('user_lastname');
        $obj->user_gender = $request->input('user_gender');
        $obj->religion_id = $request->input('religion_id');
        $obj->user_email = $request->input('user_email');
        $obj->user_phone = $request->input('user_phone');
        $obj->password = bcrypt('password');
        $obj->user_avatar = 'avatar.jpg';
        $obj->user_status = 'ACTIVE';
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        //dd($request->input('role_id'));

        User::find($obj->user_id)->roles()->sync($request->input('role_id'));

        /*dd($obj->user_id);

        $insertedID = $obj->user_id;
        foreach ($request->input('role_id[]') as $key => $value) {
            $role = new Role;
        }*/

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('user');
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
        $this->searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'user_id';
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
        $data['rows'] = User::where('active','1')
                            ->where(function($query) {
                                $query->where('user_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('user_email','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('user_lastname','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('user_phone','like','%' . $this->searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = User::where('active','1')
                                ->where(function($query) {
                                    $query->where('user_name','like','%' . $this->searchPhrase . '%')
                                            ->orWhere('user_email','like','%' . $this->searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $this->searchPhrase . '%')
                                            ->orWhere('user_lastname','like','%' . $this->searchPhrase . '%')
                                            ->orWhere('user_phone','like','%' . $this->searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }
}
