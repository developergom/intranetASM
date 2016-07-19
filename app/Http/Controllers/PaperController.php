<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Paper;
use App\Unit;

class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Paper Types Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.paper.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Paper Types Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['unit'] = Unit::where('active','1')->orderBy('unit_name')->get();
        return view('vendor.material.master.paper.create', $data);
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
            'unit_id' => 'required',
            'paper_name' => 'required|max:100',
            'paper_width' => 'required|numeric',
            'paper_length' => 'required|numeric',
        ]);

        $obj = new Paper;

        $obj->unit_id = $request->input('unit_id');
        $obj->paper_name = $request->input('paper_name');
        $obj->paper_width = $request->input('paper_width');
        $obj->paper_length = $request->input('paper_length');
        $obj->paper_desc = $request->input('paper_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/paper');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Paper Types Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['paper'] = Paper::where('active','1')->find($id);
        return view('vendor.material.master.paper.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Paper Types Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['unit'] = Unit::where('active','1')->orderBy('unit_name')->get();
        $data['paper'] = Paper::where('active','1')->find($id);
        return view('vendor.material.master.paper.edit', $data);
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
            'unit_id' => 'required',
            'paper_name' => 'required|max:100',
            'paper_width' => 'required|numeric',
            'paper_length' => 'required|numeric',
        ]);

        $obj = Paper::find($id);

        $obj->unit_id = $request->input('unit_id');
        $obj->paper_name = $request->input('paper_name');
        $obj->paper_width = $request->input('paper_width');
        $obj->paper_length = $request->input('paper_length');
        $obj->paper_desc = $request->input('paper_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/paper');
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
        
        $sort_column = 'paper_id';
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
        $data['rows'] = Paper::join('units','units.unit_id','=','papers.unit_id')
                            ->where('papers.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('paper_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('paper_width','like','%' . $searchPhrase . '%')
                                        ->orWhere('paper_length','like','%' . $searchPhrase . '%')
                                        ->orWhere('unit_code','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Paper::join('units','units.unit_id','=','papers.unit_id')
                                ->where('papers.active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('paper_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('paper_width','like','%' . $searchPhrase . '%')
                                        ->orWhere('paper_length','like','%' . $searchPhrase . '%')
                                        ->orWhere('unit_code','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Paper Types Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('paper_id');

        $obj = Paper::find($id);

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
