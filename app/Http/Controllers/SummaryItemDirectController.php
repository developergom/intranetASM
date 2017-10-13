<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Client;
use App\ClientContact;
use App\Flow;
use App\Industry;
use App\Media;
use App\OmzetType;
use App\PO;
use App\Proposal;
use App\ProposalHistory;
use App\Rate;
use App\Summary;
use App\SummaryItem;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\GeneratorLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class SummaryItemDirectController extends Controller
{
    private $notif;
    private $summary_item_types = [];
    private $summary_item_viewed = [];

    public function __construct() {
        $this->notif = new NotificationLibrary;
        $this->summary_item_types = ['cost_pro', 'media_cost'];
        $this->summary_item_viewed = ['PROCESS', 'CONFIRMED', 'TBC', 'COMPLETED'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Direct Order-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.posisiiklan.directorder.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Direct Order-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['industry'] = Industry::where('active','1')->orderBy('industry_name')->get();
        $data['omzettypes'] = OmzetType::where('active', '1')->orderBy('omzet_type_name')->get();
        $data['summary_item_types'] = $this->summary_item_types;
        $data['summary_item_viewed'] = $this->summary_item_viewed;
        
        return view('vendor.material.posisiiklan.directorder.create', $data);
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'summary_item_title' => 'required|max:255',
            'client_id' => 'required',
            'industry_id' => 'required',
            'rate_id' => 'required',
            'summary_item_period_start' => 'required',
            'omzet_type_id' => 'required',
            'summary_item_type' => 'required',
            'summary_item_insertion' => 'required|numeric',
            'summary_item_gross' => 'required|numeric',
            'summary_item_disc' => 'required|numeric',
            'summary_item_nett' => 'required|numeric',
            'summary_item_po' => 'required|numeric',
            'summary_item_ppn' => 'required|numeric',
            'summary_item_internal_omzet' => 'required|numeric',
            'summary_item_total' => 'required|numeric',
            'summary_item_viewed' => 'required'
        ]);

        $obj = new SummaryItem;

        $obj->summary_id = 0;
        $obj->rate_id = $request->input('rate_id');
        $obj->summary_item_type = $request->input('summary_item_type');
        $obj->summary_item_period_start = Carbon::createFromFormat('d/m/Y', $request->input('summary_item_period_start'))->toDateString();
        $obj->summary_item_period_end = ($request->input('summary_item_period_end')!='') ? Carbon::createFromFormat('d/m/Y', $request->input('summary_item_period_end'))->toDateString() : '';
        $obj->omzet_type_id = $request->input('omzet_type_id');
        $obj->summary_item_insertion = $request->input('summary_item_insertion');
        $obj->summary_item_gross = $request->input('summary_item_gross');
        $obj->summary_item_disc = $request->input('summary_item_disc');
        $obj->summary_item_nett = $request->input('summary_item_nett');
        $obj->summary_item_po = $request->input('summary_item_po');
        $obj->summary_item_internal_omzet = $request->input('summary_item_internal_omzet');
        $obj->summary_item_remarks = $request->input('summary_item_remarks');
        $obj->page_no = $request->input('page_no');
        $obj->summary_item_canal = $request->input('summary_item_canal');
        $obj->summary_item_order_digital = $request->input('summary_item_order_digital');
        $obj->summary_item_materi = $request->input('summary_item_materi');
        $obj->summary_item_status_materi = $request->input('summary_item_status_materi');
        $obj->summary_item_capture_materi = $request->input('summary_item_capture_materi');
        $obj->summary_item_sales_order = $request->input('summary_item_sales_order');
        $obj->summary_item_ppn = $request->input('summary_item_ppn');
        $obj->summary_item_total = $request->input('summary_item_total');
        $obj->client_id = $request->input('client_id');
        $obj->summary_item_title = $request->input('summary_item_title');
        $obj->industry_id = $request->input('industry_id');
        $obj->sales_id = $request->user()->user_id;
        $obj->summary_item_pic = $request->user()->user_id;
        $obj->summary_item_task_status = 0;
        $obj->summary_item_termin = 1;
        $obj->summary_item_viewed = $request->input('summary_item_viewed');
        $obj->source_type = 'DIRECT';
        $obj->summary_item_edited = 'NO';
        $obj->revision_no = 1;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('posisi-iklan/direct-order');
    }

    public function show($id)
    {
    	if(Gate::denies('Direct Order-Read')) {
    		abort(403, 'Unauthorized action.');
    	}

    	$data = array();

    	$data['industry'] = Industry::where('active','1')->orderBy('industry_name')->get();
        $data['omzettypes'] = OmzetType::where('active', '1')->orderBy('omzet_type_name')->get();
        $data['summary_item_types'] = $this->summary_item_types;
        $data['summary_item_viewed'] = $this->summary_item_viewed;
    	$data['summaryitem'] = SummaryItem::with(
    											'rate',
    											'rate.media'
    										)
    										->find($id);
    	$data['summary_item_period_start'] = Carbon::createFromFormat('Y-m-d', $data['summaryitem']->summary_item_period_start)->format('d/m/Y');
        $data['summary_item_period_end'] = ($data['summaryitem']->summary_item_period_end!='0000-00-00') ? Carbon::createFromFormat('Y-m-d', $data['summaryitem']->summary_item_period_end)->format('d/m/Y') : '';

    	return view('vendor.material.posisiiklan.directorder.show', $data);
    }

    public function edit($id)
    {
    	if(Gate::denies('Direct Order-Update')) {
    		abort(403, 'Unauthorized action.');
    	}

    	$data = array();

    	$data['industry'] = Industry::where('active','1')->orderBy('industry_name')->get();
        $data['omzettypes'] = OmzetType::where('active', '1')->orderBy('omzet_type_name')->get();
        $data['summary_item_types'] = $this->summary_item_types;
        $data['summary_item_viewed'] = $this->summary_item_viewed;
    	$data['summaryitem'] = SummaryItem::with(
    											'rate',
    											'rate.media'
    										)
    										->find($id);
    	$data['summary_item_period_start'] = Carbon::createFromFormat('Y-m-d', $data['summaryitem']->summary_item_period_start)->format('d/m/Y');
        $data['summary_item_period_end'] = ($data['summaryitem']->summary_item_period_end!='0000-00-00') ? Carbon::createFromFormat('Y-m-d', $data['summaryitem']->summary_item_period_end)->format('d/m/Y') : '';

    	return view('vendor.material.posisiiklan.directorder.edit', $data);
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'summary_item_title' => 'required|max:255',
            'client_id' => 'required',
            'industry_id' => 'required',
            'rate_id' => 'required',
            'summary_item_period_start' => 'required',
            'omzet_type_id' => 'required',
            'summary_item_type' => 'required',
            'summary_item_insertion' => 'required|numeric',
            'summary_item_gross' => 'required|numeric',
            'summary_item_disc' => 'required|numeric',
            'summary_item_nett' => 'required|numeric',
            'summary_item_po' => 'required|numeric',
            'summary_item_ppn' => 'required|numeric',
            'summary_item_internal_omzet' => 'required|numeric',
            'summary_item_total' => 'required|numeric',
            'summary_item_viewed' => 'required'
        ]);

        $obj = SummaryItem::find($id);

        $obj->rate_id = $request->input('rate_id');
        $obj->summary_item_type = $request->input('summary_item_type');
        $obj->summary_item_period_start = Carbon::createFromFormat('d/m/Y', $request->input('summary_item_period_start'))->toDateString();
        $obj->summary_item_period_end = ($request->input('summary_item_period_end')!='') ? Carbon::createFromFormat('d/m/Y', $request->input('summary_item_period_end'))->toDateString() : '';
        $obj->omzet_type_id = $request->input('omzet_type_id');
        $obj->summary_item_insertion = $request->input('summary_item_insertion');
        $obj->summary_item_gross = $request->input('summary_item_gross');
        $obj->summary_item_disc = $request->input('summary_item_disc');
        $obj->summary_item_nett = $request->input('summary_item_nett');
        $obj->summary_item_po = $request->input('summary_item_po');
        $obj->summary_item_internal_omzet = $request->input('summary_item_internal_omzet');
        $obj->summary_item_remarks = $request->input('summary_item_remarks');
        $obj->page_no = $request->input('page_no');
        $obj->summary_item_canal = $request->input('summary_item_canal');
        $obj->summary_item_order_digital = $request->input('summary_item_order_digital');
        $obj->summary_item_materi = $request->input('summary_item_materi');
        $obj->summary_item_status_materi = $request->input('summary_item_status_materi');
        $obj->summary_item_capture_materi = $request->input('summary_item_capture_materi');
        $obj->summary_item_sales_order = $request->input('summary_item_sales_order');
        $obj->summary_item_ppn = $request->input('summary_item_ppn');
        $obj->summary_item_total = $request->input('summary_item_total');
        $obj->client_id = $request->input('client_id');
        $obj->summary_item_title = $request->input('summary_item_title');
        $obj->industry_id = $request->input('industry_id');
        $obj->summary_item_viewed = $request->input('summary_item_viewed');
        $obj->summary_item_edited = 'YES';
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('posisi-iklan/direct-order');
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Direct Order-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('summary_item_id');

        $obj = SummaryItem::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'summary_items.updated_at';
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
        $data['rows'] = SummaryItem::select('summary_items.updated_at', 'summary_item_id', 'summary_item_title', 'clients.client_name', 'rates.rate_name', 'summary_item_period_start', 'users.user_firstname')
        					->join('clients','clients.client_id', '=', 'summary_items.client_id')
                            ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                            ->join('users', 'users.user_id', '=', 'summary_items.sales_id')
                            ->where('summary_items.active','1')
                            ->where('summary_items.source_type','DIRECT')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('summary_item_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = SummaryItem::select('summary_items.updated_at', 'summary_item_id', 'summary_item_title', 'clients.client_name', 'rates.rate_name', 'summary_item_period_start', 'users.user_firstname')
        					->join('clients','clients.client_id', '=', 'summary_items.client_id')
                            ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                            ->join('users', 'users.user_id', '=', 'summary_items.sales_id')
                            ->where('summary_items.active','1')
                            ->where('summary_items.source_type','DIRECT')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('summary_item_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }
}
