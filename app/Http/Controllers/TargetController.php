<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Industry;
use App\Media;
use App\Target;

use App\Ibrol\Libraries\GeneratorLibrary;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Target Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.target.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Target Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();
        $data['industries'] = Industry::where('active','1')->orderBy('industry_name')->get();

        return view('vendor.material.master.target.create', $data);
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
            'target_code' => 'required|unique:targets,target_code|max:20',
            'media_id' => 'required',
            'industry_id' => 'required',
            'target_year' => 'required|numeric',
            'target_month' => 'required',
            'target_amount' => 'required|numeric',
        ]);

        $obj = new Target;

        $obj->target_code = $request->input('target_code');
        $obj->media_id = $request->input('media_id');
        $obj->industry_id = $request->input('industry_id');
        $obj->target_year = $request->input('target_year');
        $obj->target_month = $request->input('target_month');
        $obj->target_amount = $request->input('target_amount');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/target');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Target Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['target'] = Target::with('industry','media')->find($id);
        return view('vendor.material.master.target.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Target Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();
        $data['industries'] = Industry::where('active','1')->orderBy('industry_name')->get();
        $data['target'] = Target::find($id);

        return view('vendor.material.master.target.edit', $data);
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
            'target_code' => 'required|unique:targets,target_code,'.$id.',target_id|max:20',
            'media_id' => 'required',
            'industry_id' => 'required',
            'target_year' => 'required|numeric',
            'target_month' => 'required',
            'target_amount' => 'required|numeric',
        ]);

        $obj = Target::find($id);

        $obj->target_code = $request->input('target_code');
        $obj->media_id = $request->input('media_id');
        $obj->industry_id = $request->input('industry_id');
        $obj->target_year = $request->input('target_year');
        $obj->target_month = $request->input('target_month');
        $obj->target_amount = $request->input('target_amount');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/target');
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'target_id';
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
        $data['rows'] = Target::join('medias','medias.media_id','=','targets.media_id')
                            ->join('industries','industries.industry_id','=','targets.industry_id')
                            ->where('targets.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('target_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('industry_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('target_month','like','%' . $searchPhrase . '%')
                                        ->orWhere('target_year','like','%' . $searchPhrase . '%')
                                        ->orWhere('target_amount','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Target::join('medias','medias.media_id','=','targets.media_id')
                            ->join('industries','industries.industry_id','=','targets.industry_id')
                            ->where('targets.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('target_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('industry_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('target_month','like','%' . $searchPhrase . '%')
                                        ->orWhere('target_year','like','%' . $searchPhrase . '%')
                                        ->orWhere('target_amount','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Target Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('target_id');

        $obj = Target::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiGenerateCode(Request $request)
    {
    	$generator = new GeneratorLibrary;
    	$data = array();

    	$data['code'] = $generator->target_code($request->input('media_id'), $request->input('industry_id'), $request->input('target_month'), $request->input('target_year'));

    	return response()->json($data);
    }
}
