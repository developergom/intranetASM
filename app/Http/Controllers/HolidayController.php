<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\Holiday;

class HolidayController extends Controller
{
    protected $searchPhrase = '';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('vendor.material.master.holiday.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('vendor.material.master.holiday.create');
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
            'holiday_name' => 'required|max:100',
            'holiday_date' => 'required',
        ]);

        $obj = new Holiday;

        $obj->holiday_name = $request->input('holiday_name');
        $obj->holiday_date = Carbon::createFromFormat('d/m/Y', $request->input('holiday_date'))->toDateString();
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/holiday');
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
        $data = array();
        $data['holiday'] = Holiday::where('active','1')->find($id);
        return view('vendor.material.master.holiday.show', $data);
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
        $data = array();
        $data['holiday'] = Holiday::where('active','1')->find($id);
        return view('vendor.material.master.holiday.edit', $data);
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
            'holiday_name' => 'required|max:100',
            'holiday_date' => 'required',
        ]);

        $obj = holiday::find($id);

        $obj->holiday_name = $request->input('holiday_name');
        $obj->holiday_date = Carbon::createFromFormat('d/m/Y', $request->input('holiday_date'))->toDateString();
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/holiday');
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
        
        $sort_column = 'holiday_id';
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
        $data['rows'] = Holiday::where('active','1')
                            ->where(function($query) {
                                $query->where('holiday_name','like','%' . $this->searchPhrase . '%')
                                    ->orWhere('holiday_date','like','%' . $this->searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Holiday::where('active','1')
                                ->where(function($query) {
                                    $query->where('holiday_name','like','%' . $this->searchPhrase . '%')
                                        ->orWhere('holiday_date','like','%' . $this->searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('holiday_id');

        $obj = Holiday::find($id);

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
