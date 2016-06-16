<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests;
use App\AdvertiseSize;
use App\Unit;

class AdvertiseSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendor.material.master.advertise_size.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['unit'] = Unit::where('active','1')->orderBy('unit_name')->get();
        return view('vendor.material.master.advertise_size.create', $data);
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
            'advertise_size_code' => 'required|max:10|unique:advertise_sizes,advertise_size_code',
            'advertise_size_name' => 'required|max:100',
            'unit_id' => 'required',
            'advertise_size_width' => 'required|numeric',
            'advertise_size_length' => 'required|numeric',
        ]);

        $obj = new AdvertiseSize;

        $obj->advertise_size_code = $request->input('advertise_size_code');
        $obj->advertise_size_name = $request->input('advertise_size_name');
        $obj->advertise_size_desc = $request->input('advertise_size_desc');
        $obj->unit_id = $request->input('unit_id');
        $obj->advertise_size_width = $request->input('advertise_size_width');
        $obj->advertise_size_length = $request->input('advertise_size_length');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/advertisesize');
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
        $data['advertisesize'] = AdvertiseSize::where('active','1')->find($id);
        return view('vendor.material.master.advertise_size.show', $data);
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
        $data['unit'] = Unit::where('active','1')->get();
        $data['advertisesize'] = AdvertiseSize::where('active','1')->find($id);
        return view('vendor.material.master.advertise_size.edit', $data);
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
            'advertise_size_code' => 'required|max:10|unique:advertise_sizes,advertise_size_code,' . $id . ',advertise_size_id',
            'advertise_size_name' => 'required|max:100',
            'unit_id' => 'required',
            'advertise_size_width' => 'required|numeric',
            'advertise_size_length' => 'required|numeric',
        ]);

        $obj = AdvertiseSize::find($id);

        $obj->advertise_size_code = $request->input('advertise_size_code');
        $obj->advertise_size_name = $request->input('advertise_size_name');
        $obj->advertise_size_desc = $request->input('advertise_size_desc');
        $obj->unit_id = $request->input('unit_id');
        $obj->advertise_size_width = $request->input('advertise_size_width');
        $obj->advertise_size_length = $request->input('advertise_size_length');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/advertisesize');
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
        
        $sort_column = 'advertise_size_id';
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
        $data['rows'] = AdvertiseSize::join('units','units.unit_id','=','advertise_sizes.unit_id')
                            ->where('advertise_sizes.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('advertise_size_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('advertise_size_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('advertise_size_width','like','%' . $searchPhrase . '%')
                                        ->orWhere('advertise_size_length','like','%' . $searchPhrase . '%')
                                        ->orWhere('unit_code','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = AdvertiseSize::join('units','units.unit_id','=','advertise_sizes.unit_id')
                                ->where('advertise_sizes.active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('advertise_size_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('advertise_size_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('advertise_size_width','like','%' . $searchPhrase . '%')
                                        ->orWhere('advertise_size_length','like','%' . $searchPhrase . '%')
                                        ->orWhere('unit_code','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('advertise_size_id');

        $obj = AdvertiseSize::find($id);

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
