<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\Unit;

class UnitController extends Controller
{
    protected $searchPhrase = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendor.material.master.unit.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendor.material.master.unit.create');
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
            'unit_code' => 'required|max:5|unique:units,unit_code',
            'unit_name' => 'required|max:100',
        ]);

        $obj = new Unit;

        $obj->unit_code = $request->input('unit_code');
        $obj->unit_name = $request->input('unit_name');
        $obj->unit_desc = $request->input('unit_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/unit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = array();
        $data['unit'] = Unit::where('active','1')->find($id);
        return view('vendor.material.master.unit.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['unit'] = Unit::where('active','1')->find($id);
        return view('vendor.material.master.unit.edit', $data);
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
            'unit_code' => 'required|max:5|unique:units,unit_code,'.$id.',unit_id',
            'unit_name' => 'required|max:100',
        ]);

        $obj = Unit::find($id);

        $obj->unit_code = $request->input('unit_code');
        $obj->unit_name = $request->input('unit_name');
        $obj->unit_desc = $request->input('unit_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/unit');
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
        
        $sort_column = 'unit_id';
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
        $data['rows'] = Unit::where('active','1')
                            ->where(function($query) {
                                $query->where('unit_code','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('unit_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('unit_desc','like','%' . $this->searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Unit::where('active','1')
                                ->where(function($query) {
                                    $query->where('unit_code','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('unit_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('unit_desc','like','%' . $this->searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('unit_id');

        $obj = Unit::find($id);

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
