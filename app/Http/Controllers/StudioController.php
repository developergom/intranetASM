<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Studio;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Studios Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.studio.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Studios Management-Create')) {
            abort(403, 'Unauthorized action.');
        }
           
        return view('vendor.material.master.studio.create');
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
            'studio_name' => 'required|max:255',
        ]);

        $obj = new Studio;

        $obj->studio_name = $request->input('studio_name');
        $obj->studio_desc = $request->input('studio_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/studio');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Studios Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['studio'] = Studio::where('active','1')->find($id);
        return view('vendor.material.master.studio.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Studios Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['studio'] = Studio::where('active','1')->find($id);
        return view('vendor.material.master.studio.edit', $data);
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
            'studio_name' => 'required|max:100',
        ]);

        $obj = Studio::find($id);

        $obj->studio_name = $request->input('studio_name');
        $obj->studio_desc = $request->input('studio_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/studio');
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
        
        $sort_column = 'studio_id';
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
        $data['rows'] = Studio::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('studio_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('studio_desc','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Studio::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('studio_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('studio_desc','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Studios Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('studio_id');

        $obj = Studio::find($id);

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
