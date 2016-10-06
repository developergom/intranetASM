<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Carbon\Carbon;
use Gate;
use App\Http\Requests;
use App\Announcement;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Announcement Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.announcement.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Announcement Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.announcement.create');
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
            'announcement_title' => 'required|max:255',
            'announcement_detail' => 'required',
            'announcement_startdate' => 'required|date_format:"d/m/Y"',
            'announcement_enddate' => 'required|date_format:"d/m/Y"',
        ]);

        $obj = new Announcement;

        $obj->announcement_title = $request->input('announcement_title');
        $obj->announcement_detail = $request->input('announcement_detail');
        $obj->announcement_startdate = Carbon::createFromFormat('d/m/Y', $request->input('announcement_startdate'))->toDateString();
        $obj->announcement_enddate = Carbon::createFromFormat('d/m/Y', $request->input('announcement_enddate'))->toDateString();
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('config/announcement');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Announcement Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['announcement'] = Announcement::where('active','1')->find($id);
        $announcement_startdate = Carbon::createFromFormat('Y-m-d', ($data['announcement']->announcement_startdate==null) ? date('Y-m-d') : $data['announcement']->announcement_startdate);
        $data['announcement_startdate'] = $announcement_startdate->format('d/m/Y');
        $announcement_enddate = Carbon::createFromFormat('Y-m-d', ($data['announcement']->announcement_enddate==null) ? date('Y-m-d') : $data['announcement']->announcement_enddate);
        $data['announcement_enddate'] = $announcement_enddate->format('d/m/Y');
        return view('vendor.material.config.announcement.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Announcement Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['announcement'] = Announcement::where('active','1')->find($id);
        $announcement_startdate = Carbon::createFromFormat('Y-m-d', ($data['announcement']->announcement_startdate==null) ? date('Y-m-d') : $data['announcement']->announcement_startdate);
        $data['announcement_startdate'] = $announcement_startdate->format('d/m/Y');
        $announcement_enddate = Carbon::createFromFormat('Y-m-d', ($data['announcement']->announcement_enddate==null) ? date('Y-m-d') : $data['announcement']->announcement_enddate);
        $data['announcement_enddate'] = $announcement_enddate->format('d/m/Y');
        return view('vendor.material.config.announcement.edit', $data);
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
            'announcement_title' => 'required|max:255',
            'announcement_detail' => 'required',
            'announcement_startdate' => 'required|date_format:"d/m/Y"',
            'announcement_enddate' => 'required|date_format:"d/m/Y"',
        ]);

        $obj = Announcement::find($id);

        $obj->announcement_title = $request->input('announcement_title');
        $obj->announcement_detail = $request->input('announcement_detail');
        $obj->announcement_startdate = Carbon::createFromFormat('d/m/Y', $request->input('announcement_startdate'))->toDateString();
        $obj->announcement_enddate = Carbon::createFromFormat('d/m/Y', $request->input('announcement_enddate'))->toDateString();
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('config/announcement');
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
        
        $sort_column = 'announcement_id';
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
        $data['rows'] = Announcement::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('announcement_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('announcement_startdate','like','%' . $searchPhrase . '%')
                                        ->orWhere('announcement_enddate','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Announcement::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('announcement_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('announcement_startdate','like','%' . $searchPhrase . '%')
                                        ->orWhere('announcement_enddate','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Announcement Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('announcement_id');

        $obj = Announcement::find($id);

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
