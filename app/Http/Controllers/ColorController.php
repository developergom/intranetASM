<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Colors Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.color.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Colors Management-Create')) {
            abort(403, 'Unauthorized action.');
        }
           
        return view('vendor.material.master.color.create');
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
            'color_name' => 'required|max:255',
        ]);

        $obj = new Color;

        $obj->color_name = $request->input('color_name');
        $obj->color_desc = $request->input('color_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/color');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Colors Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['color'] = Color::where('active','1')->find($id);
        return view('vendor.material.master.color.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Colors Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['color'] = Color::where('active','1')->find($id);
        return view('vendor.material.master.color.edit', $data);
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
            'color_name' => 'required|max:100',
        ]);

        $obj = Color::find($id);

        $obj->color_name = $request->input('color_name');
        $obj->color_desc = $request->input('color_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/color');
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
        
        $sort_column = 'color_id';
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
        $data['rows'] = Color::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('color_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('color_desc','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Color::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('color_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('color_desc','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Colors Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('color_id');

        $obj = Color::find($id);

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
