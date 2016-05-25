<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

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

        $obj = new User;
        $obj->user_name = $request->input('user_name');
        $obj->user_firstname = $request->input('user_firstname');
        $obj->user_lastname = $request->input('user_lastname');
        $obj->user_gender = $request->input('user_gender');
        $obj->user_birthdate = Carbon::createFromFormat('d/m/Y', $request->input('user_birthdate'))->toDateString();
        $obj->religion_id = $request->input('religion_id');
        $obj->user_email = $request->input('user_email');
        $obj->user_phone = $request->input('user_phone');
        $obj->password = bcrypt('password');
        $obj->user_avatar = 'avatar.jpg';
        $obj->user_status = 'ACTIVE';
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        User::find($obj->user_id)->roles()->sync($request->input('role_id'));

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
        $data = array();
        $data['user'] = User::with('religion')->find($id);
        $birthdate = Carbon::createFromFormat('Y-m-d', ($data['user']->user_birthdate==null) ? date('Y-m-d') : $data['user']->user_birthdate);
        $data['birthdate'] = $birthdate->format('d/m/Y');
        $data['roles'] = Role::where('active','1')->get();
        return view('vendor.material.user.show', $data);
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
        $data['user'] = User::find($id);
        $birthdate = Carbon::createFromFormat('Y-m-d', ($data['user']->user_birthdate==null) ? date('Y-m-d') : $data['user']->user_birthdate);
        $data['birthdate'] = $birthdate->format('d/m/Y');
        $data['religion'] = Religion::where('active','1')->get();
        $data['roles'] = Role::where('active','1')->get();
        return view('vendor.material.user.edit', $data);
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
            'user_name' => 'required|unique:users,user_name,'.$id.',user_id|max:100|min:6',
            'user_firstname' => 'required|max:100',
            'user_birthdate' => 'required',
            'user_gender' => 'required',
            'religion_id' => 'required',
            'user_email' => 'required|unique:users,user_email,'.$id.',user_id|max:100',
            'user_phone' => 'digits_between:10, 14',
            'role_id[]' => 'array',
        ]);

        $obj = User::find($id);

        $obj->user_name = $request->input('user_name');
        $obj->user_firstname = $request->input('user_firstname');
        $obj->user_lastname = $request->input('user_lastname');
        $obj->user_gender = $request->input('user_gender');
        $obj->user_birthdate = Carbon::createFromFormat('d/m/Y', $request->input('user_birthdate'))->toDateString();
        $obj->religion_id = $request->input('religion_id');
        $obj->user_email = $request->input('user_email');
        $obj->user_phone = $request->input('user_phone');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        User::find($id)->roles()->sync($request->input('role_id'));

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('user');
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

    public function apiDelete(Request $request)
    {
        $user_id = $request->input('user_id');

        $obj = User::find($user_id);

        $obj->user_status = 'INACTIVE';
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
