<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Organizations Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.organization.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Organizations Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.organization.create');
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
            'organization_name' => 'required|max:100',
            'organization_account_name' => 'max|50',
            'organization_account_no' => 'max|50',
            'organization_term_of_payment' => 'numeric'
        ]);

        $obj = new Organization;

        $obj->organization_name = $request->input('organization_name');
        $obj->organization_account_name = $request->input('organization_account_name');
        $obj->organization_account_no = $request->input('organization_account_no');
        $obj->organization_term_of_payment = $request->input('organization_term_of_payment');
        $obj->organization_desc = $request->input('organization_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/organization');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Organizations Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['organization'] = Organization::with(['medias' => function($query){
                                    $query->orderBy('media_name');
                                }])->where('active','1')->find($id);
        return view('vendor.material.master.organization.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Organizations Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['organization'] = Organization::where('active','1')->find($id);
        return view('vendor.material.master.organization.edit', $data);
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
            'organization_name' => 'required|max:100',
            'organization_account_name' => 'max|50',
            'organization_account_no' => 'max|50',
            'organization_term_of_payment' => 'numeric'
        ]);

        $obj = Organization::find($id);

        $obj->organization_name = $request->input('organization_name');
        $obj->organization_account_name = $request->input('organization_account_name');
        $obj->organization_account_no = $request->input('organization_account_no');
        $obj->organization_term_of_payment = $request->input('organization_term_of_payment');
        $obj->organization_desc = $request->input('organization_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/organization');
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
        
        $sort_column = 'organization_id';
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
        $data['rows'] = Organization::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('organization_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('organization_account_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('organization_account_no','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Organization::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('organization_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('organization_account_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('organization_account_no','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Organizations Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('organization_id');

        $obj = Organization::find($id);

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
