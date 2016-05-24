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
