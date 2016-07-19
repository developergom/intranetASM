<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Religion;

class ReligionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Gate::denies('Religions Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.religion.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if(Gate::denies('Religions Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.religion.create');
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
            'religion_name' => 'required|max:100'
        ]);

        $obj = new Religion;

        $obj->religion_name = $request->input('religion_name');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/religion');
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
        if(Gate::denies('Religions Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['religion'] = Religion::where('active','1')->find($id);
        return view('vendor.material.master.religion.show', $data);
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
        if(Gate::denies('Religions Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['religion'] = Religion::where('active','1')->find($id);
        return view('vendor.material.master.religion.edit', $data);
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
            'religion_name' => 'required|max:100',
        ]);

        $obj = Religion::find($id);

        $obj->religion_name = $request->input('religion_name');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/religion');
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
        
        $sort_column = 'religion_id';
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
        $data['rows'] = Religion::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('religion_name','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Religion::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('religion_name','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiEdit(Request $request)
    {
        if(Gate::denies('Religions Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('religion_id');

        $obj = Religion::find($id);

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
