<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\MediaGroup;
use App\Publisher;

class MediaGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Media Groups Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.mediagroup.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Media Groups Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['publishers'] = Publisher::where('active', '1')->get();

        return view('vendor.material.master.mediagroup.create', $data);
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
            'publisher_id' => 'required',
            'media_group_code' => 'required|max:5|unique:media_groups,media_group_code',
            'media_group_name' => 'required|max:100',
        ]);

        $obj = new MediaGroup;

        $obj->publisher_id = $request->input('publisher_id');
        $obj->media_group_code = $request->input('media_group_code');
        $obj->media_group_name = $request->input('media_group_name');
        $obj->media_group_desc = $request->input('media_group_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/mediagroup');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Media Groups Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['mediagroup'] = MediaGroup::where('active','1')->find($id);
        return view('vendor.material.master.mediagroup.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Media Groups Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['publishers'] = Publisher::where('active', '1')->get();
        $data['mediagroup'] = MediaGroup::where('active','1')->find($id);
        return view('vendor.material.master.mediagroup.edit', $data);
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
            'publisher_id' => 'required',
            'media_group_code' => 'required|max:5|unique:media_groups,media_group_code,'.$id.',media_group_id',
            'media_group_name' => 'required|max:100',
        ]);

        $obj = MediaGroup::find($id);

        $obj->publisher_id = $request->input('publisher_id');
        $obj->media_group_code = $request->input('media_group_code');
        $obj->media_group_name = $request->input('media_group_name');
        $obj->media_group_desc = $request->input('media_group_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/mediagroup');
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
        
        $sort_column = 'media_group_id';
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
        $data['rows'] = MediaGroup::join('publishers', 'publishers.publisher_id', '=', 'media_groups.publisher_id')
                            ->where('media_groups.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('publisher_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_desc','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = MediaGroup::join('publishers', 'publishers.publisher_id', '=', 'media_groups.publisher_id')
                                ->where('media_groups.active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('publisher_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_desc','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Media Groups Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('media_group_id');

        $obj = MediaGroup::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiGetOption(Request $request)
    {
        if(Gate::denies('Media Groups Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('publisher_id');

        $data = MediaGroup::where('active', '1')->where('publisher_id', $id)->orderBy('media_group_name', 'asc')->get();

        return response()->json($data);
    }
}
