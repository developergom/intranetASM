<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use Hash;
use App\Http\Requests;
use App\User;
use App\Group;
use App\Media;
use App\MediaGroup;
use App\Religion;
use App\Role;

class UserController extends Controller
{
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
        if(Gate::denies('Users Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

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
        if(Gate::denies('Users Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['religion'] = Religion::where('active','1')->orderBy('religion_name')->get();
        $data['roles'] = Role::where('active','1')->orderBy('role_name')->get();
        $data['groups'] = Group::where('active','1')->orderBy('group_name')->get();
        $data['medias'] = Media::where('active','1')->orderBy('media_name')->get();
        $data['mediagroups'] = MediaGroup::where('active','1')->orderBy('media_group_name')->get();

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
            'user_birthdate' => 'required|date_format:"d/m/Y"',
            'user_gender' => 'required',
            'religion_id' => 'required',
            'user_email' => 'required|unique:users,user_email|max:100',
            'user_phone' => 'digits_between:10, 14',
            'role_id[]' => 'array',
            'group_id[]' => 'array',
            'media_id[]' => 'array',
            'media_group_id[]' => 'array',
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
        $obj->user_avatar = ($request->input('user_gender')=='1') ? 'avatar.jpg' : 'avatar-female.jpg';
        $obj->user_status = 'ACTIVE';
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        User::find($obj->user_id)->roles()->sync($request->input('role_id'));
        User::find($obj->user_id)->groups()->sync($request->input('group_id'));
        if(!empty($request->input('media_id'))) {
            User::find($obj->user_id)->medias()->sync($request->input('media_id'));
        }

        if(!empty($request->input('media_group_id'))) {
            User::find($obj->user_id)->mediagroups()->sync($request->input('media_group_id'));
        }

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
        if(Gate::denies('Users Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['user'] = User::with('religion')->find($id);
        $birthdate = Carbon::createFromFormat('Y-m-d', ($data['user']->user_birthdate==null) ? date('Y-m-d') : $data['user']->user_birthdate);
        $data['birthdate'] = $birthdate->format('d/m/Y');
        $data['roles'] = Role::where('active','1')->orderBy('role_name')->get();
        $data['groups'] = Group::where('active','1')->orderBy('group_name')->get();
        $data['medias'] = Media::where('active','1')->orderBy('media_name')->get();
        $data['mediagroups'] = MediaGroup::where('active','1')->orderBy('media_group_name')->get();
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
        if(Gate::denies('Users Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['user'] = User::find($id);
        $birthdate = Carbon::createFromFormat('Y-m-d', ($data['user']->user_birthdate==null) ? date('Y-m-d') : $data['user']->user_birthdate);
        $data['birthdate'] = $birthdate->format('d/m/Y');
        $data['religion'] = Religion::where('active','1')->orderBy('religion_name')->get();
        $data['roles'] = Role::where('active','1')->orderBy('role_name')->get();
        $data['groups'] = Group::where('active','1')->orderBy('group_name')->get();
        $data['medias'] = Media::where('active','1')->orderBy('media_name')->get();
        $data['mediagroups'] = MediaGroup::where('active','1')->orderBy('media_group_name')->get();
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
            'user_birthdate' => 'required|date_format:"d/m/Y"',
            'user_gender' => 'required',
            'religion_id' => 'required',
            'user_email' => 'required|unique:users,user_email,'.$id.',user_id|max:100',
            'user_phone' => 'digits_between:10, 14',
            'role_id[]' => 'array',
            'group_id[]' => 'array',
            'media_id[]' => 'array',
            'media_group_id[]' => 'array'
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

        if($request->input('reset_password')=='yes') {
            $obj->password = bcrypt('password');
        }

        $obj->save();

        User::find($id)->roles()->sync($request->input('role_id'));
        User::find($id)->groups()->sync($request->input('group_id'));
        if(!empty($request->input('media_id'))) {
            User::find($id)->medias()->sync($request->input('media_id'));
        }

        if(!empty($request->input('media_group_id'))) {
            User::find($id)->mediagroups()->sync($request->input('media_group_id'));
        }

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
        $searchPhrase = $request->input('searchPhrase') or '';
        
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
        $data['searchPhrase'] = $searchPhrase;
        $data['rows'] = User::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('user_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_email','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_phone','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = User::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('user_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_email','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_lastname','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_phone','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Users Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

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

    public function changePassword() {
        if(Gate::denies('Home-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.user.changepassword');
    }

    public function postChangePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required|max:100',
            'new_password' => 'required|min:6|max:100',
            'confirm_new_password' => 'required|min:6|max:100|same:new_password',
        ]);

        $user = User::find($request->user()->user_id);

        if(Hash::check($request->input('old_password'), $user->password)) {
            $user->password = Hash::make($request->input('new_password'));
            $user->updated_by = $request->user()->user_id;

            $user->save();

            $request->session()->flash('status', 'Your password has been changed!');
            return redirect('home');
        }else{
            $request->session()->flash('errorchangepassword', 'Please input a correct Old Password!');
            return redirect('change-password');
        }
    }

    public function viewProfile(Request $request) {
        if(Gate::denies('Home-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['user'] = User::with('religion')->find($request->user()->user_id);
        $birthdate = Carbon::createFromFormat('Y-m-d', ($data['user']->user_birthdate==null) ? date('Y-m-d') : $data['user']->user_birthdate);
        $data['birthdate'] = $birthdate->format('d/m/Y');
        $data['religion'] = Religion::where('active','1')->orderBy('religion_name')->get();
        $data['roles'] = Role::where('active','1')->get();
        $data['groups'] = Group::where('active','1')->get();
        $data['medias'] = Media::where('active','1')->get();
        $data['mediagroups'] = MediaGroup::where('active','1')->get();

        return view('vendor.material.user.profile', $data);
    }

    public function postEditProfile(Request $request) {
        $id = $request->user()->user_id;

        $this->validate($request, [
            'user_birthdate' => 'required|date_format:"d/m/Y"',
            'religion_id' => 'required',
            'user_email' => 'required|unique:users,user_email,'.$id.',user_id|max:100',
            'user_phone' => 'digits_between:10, 14',
        ]);

        $obj = User::find($id);

        $obj->user_birthdate = Carbon::createFromFormat('d/m/Y', $request->input('user_birthdate'))->toDateString();
        $obj->religion_id = $request->input('religion_id');
        $obj->user_email = $request->input('user_email');
        $obj->user_phone = $request->input('user_phone');
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            $data = validation_errors();
            return response()->json($data); //failed
        }
    }

    public function postUploadAvatar(Request $request) {
        $id = $request->user()->user_id;

        $this->validate($request, [
            'upload_file' => 'required|image|max:2000',
        ]);

        $obj = User::find($id);

        if ($request->hasFile('upload_file')) {
            if ($request->file('upload_file')->isValid()) {
                $uploaded = $request->file('upload_file');
                $avatar = Carbon::now()->format('YmdHis') . $uploaded->getClientOriginalName();
                $uploaded->move(
                    base_path() . '/public/img/avatar/', $avatar
                );

                $obj->user_avatar = $avatar;

            }
        }

        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            $request->session()->flash('status', 'Avatar has been changed!');

            return redirect('profile');
        }
    }

    public function apiSearch(Request $request)
    {
        if(Gate::denies('Users Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $query = $request->squery;

        $result = User::where('user_firstname','like','%' . $query . '%')
                    ->orWhere('user_lastname','like','%' . $query . '%')
                    ->where('active', '1')->take(5)->orderBy('user_firstname')->get();

        return response()->json($result, 200);
    }
}
