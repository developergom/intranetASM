<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Media;
use App\PosisiIklan;
use App\PosisiIklanItem;
use App\PosisiIklanItemTask;
use App\SummaryItem;
use App\Ibrol\Libraries\UserLibrary;

class PosisiIklanItemTaskController extends Controller
{
    private $userlibrary;

    public function __construct(){
        $this->userlibrary = new UserLibrary;
    }

    public function index()
    {
    	if(Gate::denies('Item Task-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.posisiiklan.itemtask.list', $data);
    }

    public function create(Request $request)
    {
    
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {
        if(Gate::denies('Item Task-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['posisiiklanitemtask'] = PosisiIklanItemTask::with('summaryitem.rate.media', 'summaryitem.client', 'summaryitem', 'summaryitem.rate', 'summaryitem.rate.unit')->find($id);

        return view('vendor.material.posisiiklan.itemtask.show', $data);
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'summary_item_period_start';
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

        if($listtype == 'available') {
            $data['rows'] = SummaryItem::select('summary_items.summary_item_id', 'media_name', 'client_name', 'summary_item_period_start', 'summary_item_title', 'summary_items.updated_at')
                                ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                                ->join('medias','medias.media_id', '=', 'rates.media_id')
                                ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                                ->join('omzet_types','omzet_types.omzet_type_id', '=', 'summary_items.omzet_type_id')
                                ->where('summary_items.active', '=', '1')
                                ->where('summary_items.summary_item_task_status', '=' , '0')
                                ->where('omzet_types.omzet_type_name', '=', 'Print')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = SummaryItem::select('summary_items.summary_item_id', 'media_name', 'client_name', 'summary_item_period_start', 'summary_item_title', 'summary_items.updated_at')
                                ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                                ->join('medias','medias.media_id', '=', 'rates.media_id')
                                ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                                ->join('omzet_types','omzet_types.omzet_type_id', '=', 'summary_items.omzet_type_id')
                                ->where('summary_items.active', '=', '1')
                                ->where('summary_items.summary_item_task_status', '=' , '0')
                                ->where('omzet_types.omzet_type_name', '=', 'Print')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'onprocess') {
            $data['rows'] = PosisiIklanItemTask::select('posisi_iklan_item_tasks.posisi_iklan_item_task_id','media_name', 'client_name', 'summary_item_period_start', 'summary_item_title', 'posisi_iklan_item_tasks.updated_at', 'users.user_firstname', 'users.user_lastname')
                                ->join('summary_items', 'summary_items.summary_item_id', '=', 'posisi_iklan_item_tasks.summary_item_id')
                                ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                                ->join('medias','medias.media_id', '=', 'rates.media_id')
                                ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                                ->join('users', 'users.user_id', '=', 'posisi_iklan_item_tasks.posisi_iklan_item_task_pic')
                                ->where('posisi_iklan_item_tasks.active', '=', '1')
                                ->where('posisi_iklan_item_tasks.posisi_iklan_item_task_status', '=' , 'ON PROCESS')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', '=' , $request->user()->user_id)
                                            ->orWhereIn('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = PosisiIklanItemTask::select('posisi_iklan_item_tasks.posisi_iklan_item_task_id','media_name', 'client_name', 'summary_item_period_start', 'summary_item_title', 'posisi_iklan_item_tasks.updated_at', 'users.user_firstname', 'users.user_lastname')
                                ->join('summary_items', 'summary_items.summary_item_id', '=', 'posisi_iklan_item_tasks.summary_item_id')
                                ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                                ->join('medias','medias.media_id', '=', 'rates.media_id')
                                ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                                ->join('users', 'users.user_id', '=', 'posisi_iklan_item_tasks.posisi_iklan_item_task_pic')
                                ->where('posisi_iklan_item_tasks.active', '=', '1')
                                ->where('posisi_iklan_item_tasks.posisi_iklan_item_task_status', '=' , 'ON PROCESS')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', '=' , $request->user()->user_id)
                                            ->orWhereIn('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = PosisiIklanItemTask::select('posisi_iklan_item_tasks.posisi_iklan_item_task_id','media_name', 'client_name', 'summary_item_period_start', 'summary_item_title', 'posisi_iklan_item_tasks.updated_at', 'users.user_firstname', 'users.user_lastname')
                                ->join('summary_items', 'summary_items.summary_item_id', '=', 'posisi_iklan_item_tasks.summary_item_id')
                                ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                                ->join('medias','medias.media_id', '=', 'rates.media_id')
                                ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                                ->join('users', 'users.user_id', '=', 'posisi_iklan_item_tasks.posisi_iklan_item_task_pic')
                                ->where('posisi_iklan_item_tasks.active', '=', '1')
                                ->where('posisi_iklan_item_tasks.posisi_iklan_item_task_status', '=' , 'FINISHED')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', '=' , $request->user()->user_id)
                                            ->orWhereIn('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = PosisiIklanItemTask::select('posisi_iklan_item_tasks.posisi_iklan_item_task_id','media_name', 'client_name', 'summary_item_period_start', 'summary_item_title', 'posisi_iklan_item_tasks.updated_at', 'users.user_firstname', 'users.user_lastname')
                                ->join('summary_items', 'summary_items.summary_item_id', '=', 'posisi_iklan_item_tasks.summary_item_id')
                                ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                                ->join('medias','medias.media_id', '=', 'rates.media_id')
                                ->join('clients','clients.client_id', '=', 'summary_items.client_id')
                                ->join('users', 'users.user_id', '=', 'posisi_iklan_item_tasks.posisi_iklan_item_task_pic')
                                ->where('posisi_iklan_item_tasks.active', '=', '1')
                                ->where('posisi_iklan_item_tasks.posisi_iklan_item_task_status', '=' , 'FINISHED')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', '=' , $request->user()->user_id)
                                            ->orWhereIn('posisi_iklan_item_tasks.posisi_iklan_item_task_pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }

    public function take($id)
    {
        if(Gate::denies('Item Task-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['summaryitem'] = SummaryItem::with('rate', 'client', 'rate.unit')->find($id);

        return view('vendor.material.posisiiklan.itemtask.take', $data);
    }

    public function takePost(Request $request, $id)
    {
        $obj = new PosisiIklanItemTask;
        $obj->summary_item_id = $id;
        $obj->posisi_iklan_item_task_pic = $request->user()->user_id;
        $obj->posisi_iklan_item_task_status = 'ON PROCESS';
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;
        $obj->save();

        $item = SummaryItem::find($id);
        $item->summary_item_task_status = 1;
        $item->updated_by = $request->user()->user_id;
        $item->save();

        $request->session()->flash('status', 'Data has been saved!');
        return redirect('posisi-iklan/item_task');
    }

    public function updateTask($id)
    {
        if(Gate::denies('Item Task-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['posisiiklanitemtask'] = PosisiIklanItemTask::with('summaryitem.rate.media', 'summaryitem.client', 'summaryitem', 'summaryitem.rate', 'summaryitem.rate.unit')->find($id);

        return view('vendor.material.posisiiklan.itemtask.updatetask', $data);
    }

    public function updateTaskPost(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required',
            'notes' => 'required'
        ]);

        $obj = PosisiIklanItemTask::find($id);
        $obj->posisi_iklan_item_task_status = $request->input('status');
        if($request->input('status')=='FINISHED') {
            $obj->posisi_iklan_item_task_finish_time = date('Y-m-d H:i:s');
        }
        $obj->posisi_iklan_item_task_notes = $request->input('notes');
        $obj->updated_by = $request->user()->user_id;
        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');
        return redirect('posisi-iklan/item_task');
    }
}
