<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Locations Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.location.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Locations Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.location.create');
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
            'location_name' => 'required|max:50',
            'location_address' => 'required|max:150',
            'location_city' => 'required|max:50',
        ]);

        $obj = new Location;

        $obj->location_name = $request->input('location_name');
        $obj->location_address = $request->input('location_address');
        $obj->location_city = $request->input('location_city');
        $obj->location_desc = $request->input('location_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/location');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Locations Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['location'] = Location::where('active','1')->find($id);
        return view('vendor.material.master.location.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Locations Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['location'] = Location::where('active','1')->find($id);
        return view('vendor.material.master.location.edit', $data);
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
            'location_name' => 'required|max:50',
            'location_address' => 'required|max:150',
            'location_city' => 'required|max:50',
        ]);

        $obj = Location::find($id);

        $obj->location_name = $request->input('location_name');
        $obj->location_address = $request->input('location_address');
        $obj->location_city = $request->input('location_city');
        $obj->location_desc = $request->input('location_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/location');
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
        
        $sort_column = 'location_id';
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
        $data['rows'] = Location::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('location_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('location_address','like','%' . $searchPhrase . '%')
                                        ->orWhere('location_city','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Location::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('location_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('location_address','like','%' . $searchPhrase . '%')
                                        ->orWhere('location_city','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Locations Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('location_id');

        $obj = Location::find($id);

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
