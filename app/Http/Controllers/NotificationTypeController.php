<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\NotificationType;

class NotificationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Notification Types Management-Read')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.material.master.notificationtype.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Notification Types Management-Create')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.material.master.notificationtype.create');
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
            'notification_type_code' => 'required|alpha_dash|max:50|unique:notification_types,notification_type_code',
            'notification_type_name' => 'required|max:255',
            'notification_type_url' => 'required|max:255',
            'notification_type_need_confirmation' => 'required'
        ]);

        $obj = new NotificationType;

        $obj->notification_type_code = $request->input('notification_type_code');
        $obj->notification_type_name = $request->input('notification_type_name');
        $obj->notification_type_url = $request->input('notification_type_url');
        $obj->notification_type_desc = $request->input('notification_type_desc');
        $obj->notification_type_need_confirmation = $request->input('notification_type_need_confirmation');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/notificationtype');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Notification Types Management-Read')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        $data['notificationtype'] = NotificationType::where('active','1')->find($id);
        return view('vendor.material.master.notificationtype.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Notification Types Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['notificationtype'] = NotificationType::where('active','1')->find($id);
        return view('vendor.material.master.notificationtype.edit', $data);
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
            'notification_type_code' => 'required|alpha_dash|max:50|unique:notification_types,notification_type_code,' . $id . ',notification_type_id',
            'notification_type_name' => 'required|max:255',
            'notification_type_url' => 'required|max:255',
            'notification_type_need_confirmation' => 'required'
        ]);

        $obj = NotificationType::find($id);

        $obj->notification_type_code = $request->input('notification_type_code');
        $obj->notification_type_name = $request->input('notification_type_name');
        $obj->notification_type_url = $request->input('notification_type_url');
        $obj->notification_type_desc = $request->input('notification_type_desc');
        $obj->notification_type_need_confirmation = $request->input('notification_type_need_confirmation');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/notificationtype');
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
        
        $sort_column = 'notification_type_id';
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
        $data['rows'] = NotificationType::where('active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('notification_type_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('notification_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('notification_type_url','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = NotificationType::where('active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('notification_type_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('notification_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('notification_type_url','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Notification Types Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('notification_type_id');

        $obj = NotificationType::find($id);

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
