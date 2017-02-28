<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Cache;
use Gate;
use App\Http\Requests;
use App\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Application Settings-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.setting.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Application Settings-Create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.setting.create');
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
            'setting_code' => 'required|max:100|unique:settings,setting_code',
            'setting_name' => 'required|max:255',
            'setting_desc' => 'required',
            'setting_value' => 'required',
        ]);

        $obj = new Setting;

        $obj->setting_code = $request->input('setting_code');
        $obj->setting_name = $request->input('setting_name');
        $obj->setting_desc = $request->input('setting_desc');
        $obj->setting_value = $request->input('setting_value');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('config/setting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Application Settings-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['setting'] = Setting::where('active','1')->find($id);
        return view('vendor.material.config.setting.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Application Settings-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['setting'] = Setting::where('active','1')->find($id);
        return view('vendor.material.config.setting.edit', $data);
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
            'setting_code' => 'required|max:100|unique:settings,setting_code,'.$id.',setting_id',
            'setting_name' => 'required|max:255',
            'setting_desc' => 'required',
            'setting_value' => 'required',
        ]);

        $obj = Setting::find($id);

        $obj->setting_code = $request->input('setting_code');
        $obj->setting_name = $request->input('setting_name');
        $obj->setting_desc = $request->input('setting_desc');
        $obj->setting_value = $request->input('setting_value');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('config/setting');
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
        
        $sort_column = 'setting_id';
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
        $data['rows'] = Setting::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('setting_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('setting_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('setting_desc','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Setting::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('setting_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('setting_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('setting_desc','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Application Settings-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('setting_id');

        $obj = Setting::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiClearCache(Request $request)
    {
        if(Gate::denies('Application Settings-Update')) {
            return response()->json(200);
        }

        if($request->input('clear_cache')=='1')
        {
            Cache::flush();
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
