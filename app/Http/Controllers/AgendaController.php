<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use Auth;
use File;
use Carbon\Carbon;
use App\Http\Requests;
use App\Agenda;
use App\AgendaType;
use App\UploadFile;

use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Agenda Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }
        return view('vendor.material.agenda.agenda.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Agenda Plan-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['agendatypes'] = AgendaType::where('active', '1')->get();

        return view('vendor.material.agenda.agenda.create', $data);
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
            'agenda_date' => 'required|date_format:"d/m/Y"',
            'agenda_type_id' => 'required',
            //'agenda_destination' => 'required|max:100'
        ]);

        /*dd($request->input());*/

        $obj = new Agenda;

        $obj->agenda_date = Carbon::createFromFormat('d/m/Y', $request->input('agenda_date'))->toDateString();
        $obj->agenda_type_id = $request->input('agenda_type_id');
        $obj->agenda_parent = 0;
        //$obj->agenda_destination = $request->input('agenda_destination');
        $obj->agenda_destination = '';
        $obj->agenda_desc = $request->input('agenda_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        if(!empty($request->input('client_id'))) {
            Agenda::find($obj->agenda_id)->clients()->sync($request->input('client_id'));
        }

        if(!empty($request->input('client_contact_id'))) {
            Agenda::find($obj->agenda_id)->clientcontacts()->sync($request->input('client_contact_id'));
        }

        /*if(!empty($request->input('inventory_planner_id'))) {
            Agenda::find($obj->agenda_id)->inventories()->sync($request->input('inventory_planner_id'));
        }*/

        if(!empty($request->input('proposal_id'))) {
            Agenda::find($obj->agenda_id)->proposals()->sync($request->input('proposal_id'));
        }

        /*if(!is_null($request->input('client_id'))) {
            if(!empty($request->input('client_id'))) {
                Agenda::find($obj->agenda_id)->clients()->sync($request->input('client_id'));
            }            
        }

        if(!is_null($request->input('client_contact_id'))) {
            if(!empty($request->input('client_contact_id'))) {
                Agenda::find($obj->agenda_id)->clientcontacts()->sync($request->input('client_contact_id'));
            }            
        }*/

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('agenda/plan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Agenda Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        
        $data['agenda'] = Agenda::with('agendatype','clients','clientcontacts','clientcontacts.client')->find($id);
        $agenda_date = Carbon::createFromFormat('Y-m-d', ($data['agenda']->agenda_date==null) ? date('Y-m-d') : $data['agenda']->agenda_date);
        $agenda_meeting_time = Carbon::createFromFormat('Y-m-d H:i:s', ($data['agenda']->agenda_meeting_time==null) ? date('Y-m-d H:i:s') : $data['agenda']->agenda_meeting_time);
        $agenda_report_time = Carbon::createFromFormat('Y-m-d H:i:s', ($data['agenda']->agenda_report_time==null) ? date('Y-m-d H:i:s') : $data['agenda']->agenda_report_time);
        $data['agenda_date'] = $agenda_date->format('d/m/Y');
        $data['agenda_meeting_time'] = $agenda_meeting_time->format('d/m/Y H:i:s');
        $data['agenda_report_time'] = $agenda_report_time->format('d/m/Y H:i:s');

        $created_at = Carbon::createFromFormat('Y-m-d H:i:s', ($data['agenda']->created_at==null) ? date('Y-m-d H:i:s') : $data['agenda']->created_at);        
        $data['created_at'] = $created_at->format('d/m/Y H:i:s');

        return view('vendor.material.agenda.agenda.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Agenda Plan-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['agendatypes'] = AgendaType::where('active', '1')->get();
        $data['agenda'] = Agenda::find($id);
        $agenda_date = Carbon::createFromFormat('Y-m-d', ($data['agenda']->agenda_date==null) ? date('Y-m-d') : $data['agenda']->agenda_date);
        $data['agenda_date'] = $agenda_date->format('d/m/Y');
        return view('vendor.material.agenda.agenda.edit', $data);
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
            'agenda_date' => 'required|date_format:"d/m/Y"',
            'agenda_type_id' => 'required',
            //'agenda_destination' => 'required|max:100'
        ]);

        /*dd($request->input());*/

        $obj = Agenda::find($id);

        $obj->agenda_date = Carbon::createFromFormat('d/m/Y', $request->input('agenda_date'))->toDateString();
        $obj->agenda_type_id = $request->input('agenda_type_id');
        //$obj->agenda_destination = $request->input('agenda_destination');
        $obj->agenda_desc = $request->input('agenda_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        /*if(!is_null($request->input('client_id'))) {
            if(!empty($request->input('client_id'))) {
                Agenda::find($obj->agenda_id)->clients()->sync($request->input('client_id'));
            }            
        }else{
            Agenda::find($obj->agenda_id)->clients()->sync([]);
        }

        if(!is_null($request->input('client_contact_id'))) {
            if(!empty($request->input('client_contact_id'))) {
                Agenda::find($obj->agenda_id)->clientcontacts()->sync($request->input('client_contact_id'));
            }            
        }else{
            Agenda::find($obj->agenda_id)->clientcontacts()->sync([]);
        }*/

        if(!empty($request->input('client_id'))) {
            Agenda::find($obj->agenda_id)->clients()->sync($request->input('client_id'));
        }

        if(!empty($request->input('client_contact_id'))) {
            Agenda::find($obj->agenda_id)->clientcontacts()->sync($request->input('client_contact_id'));
        }

        /*if(!empty($request->input('inventory_planner_id'))) {
            Agenda::find($obj->agenda_id)->inventories()->sync($request->input('inventory_planner_id'));
        }*/

        if(!empty($request->input('proposal_id'))) {
            Agenda::find($obj->agenda_id)->proposals()->sync($request->input('proposal_id'));
        }

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('agenda/plan');
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
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $is_report = $request->input('is_report');

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'created_at';
        $sort_type = 'desc';

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
        $data['rows'] = Agenda::join('agenda_types', 'agenda_types.agenda_type_id', '=', 'agendas.agenda_type_id')
                            ->join('users', 'users.user_id', '=', 'agendas.created_by')
                            ->where('agendas.active','1')
                            ->where('agendas.agenda_is_report',$is_report)
                            ->where(function($query) use($request, $subordinate){
                                    $query->where('agendas.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('agendas.created_by', $subordinate);
                                })
                            ->where(function($query) use($searchPhrase) {
                                $query->orWhere('agenda_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('agenda_type_name','like','%' . $searchPhrase . '%')
                                        //->orWhere('agenda_destination','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Agenda::join('agenda_types', 'agenda_types.agenda_type_id', '=', 'agendas.agenda_type_id')
                                ->join('users', 'users.user_id', '=', 'agendas.created_by')
                                ->where('agendas.active','1')
                                ->where('agendas.agenda_is_report',$is_report)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('agendas.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('agendas.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('agenda_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('agenda_type_name','like','%' . $searchPhrase . '%')
                                        //->orWhere('agenda_destination','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Agenda Plan-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('agenda_id');

        $obj = Agenda::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function doReport($id)
    {
        if(Gate::denies('Agenda Plan-Create')) {
            abort(403, 'Unauthorized action.');
        }
        $data = array();
        
        $data['agenda'] = Agenda::with('agendatype','clients','clientcontacts','clientcontacts.client')->find($id);
        $agenda_date = Carbon::createFromFormat('Y-m-d', ($data['agenda']->agenda_date==null) ? date('Y-m-d') : $data['agenda']->agenda_date);
        $agenda_meeting_time = Carbon::createFromFormat('Y-m-d H:i:s', ($data['agenda']->agenda_meeting_time==null) ? date('Y-m-d H:i:s') : $data['agenda']->agenda_meeting_time);
        $agenda_report_time = Carbon::createFromFormat('Y-m-d H:i:s', ($data['agenda']->agenda_report_time==null) ? date('Y-m-d H:i:s') : $data['agenda']->agenda_report_time);
        $data['agenda_date'] = $agenda_date->format('d/m/Y');
        $data['agenda_meeting_time'] = $agenda_meeting_time->format('d/m/Y H:i:s');
        $data['agenda_report_time'] = $agenda_report_time->format('d/m/Y H:i:s');

        $created_at = Carbon::createFromFormat('Y-m-d H:i:s', ($data['agenda']->created_at==null) ? date('Y-m-d H:i:s') : $data['agenda']->created_at);        
        $data['created_at'] = $created_at->format('d/m/Y H:i:s');

        return view('vendor.material.agenda.agenda.do_report', $data);
    }

    public function postDoReport(Request $request, $id)
    {
        $this->validate($request, [
            'agenda_meeting_time' => 'required|date_format:"d/m/Y"',
            'agenda_report_desc' => 'required'
        ]);

        $obj = Agenda::find($id);

        $obj->agenda_is_report = '1';
        $obj->agenda_meeting_time = Carbon::createFromFormat('d/m/Y', $request->input('agenda_meeting_time'))->toDateString();
        $obj->agenda_report_time = Carbon::now()->toDateString();
        $obj->agenda_report_desc = $request->input('agenda_report_desc');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);
        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = 'uploads/files/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = 'uploads/files/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
            }

            if(File::move($value, $newfile)) {
                $file = pathinfo($newfile);
                $filesize = File::size($newfile);

                $upl = new UploadFile;
                $upl->upload_file_type = $file['extension'];
                $upl->upload_file_name = $file['basename'];
                $upl->upload_file_path = $file['dirname'];
                $upl->upload_file_size = $filesize;
                $upl->upload_file_revision = 0;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
            }
        }

        if(!empty($fileArray)) {
            Agenda::find($obj->agenda_id)->uploadfiles()->sync($fileArray);    
        }

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('agenda/plan');
    }

    public function apiTest(Request $request){
        $data = array(
                    array(
                        'name' => 'Soni',
                        'address' => 'Bandung'
                    ),
                    array(
                        'name' => 'Roni',
                        'address' => 'Bandung'
                    ),
                    array(
                        'name' => 'Toni',
                        'address' => 'Bandung'
                    ),
                    array(
                        'name' => 'Doni',
                        'address' => 'Bandung'
                    )
                );

        return response()->json($data);
    }
}
