<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Contract;
use App\Client;
use App\ClientContact;
use App\Media;
use App\OmzetType;
use App\Rate;
use App\Summary;
use App\SummaryHistory;
use App\SummaryItem;
use App\User;

use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class SummariesAssignedController extends Controller
{
    private $notif;

	public function __construct() {
        $this->notif = new NotificationLibrary;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Summaries Assigned-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.workorder.summariesassigned.list');
    }

    public function show($id)
    {
    	if(Gate::denies('Summaries Assigned-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data['summary'] = Summary::with([
                    'summaryitems' => function($query) { $query->orderBy('summary_item_termin', 'asc'); }, 
                    'uploadfiles',
                    'contract',
                    'contract.proposal', 
                    'contract.proposal.brand', 
                    'contract.proposal.medias', 
                    'contract.proposal.client', 
                    'contract.proposal.client.clienttype', 
                    'contract.proposal.client_contacts', 
                    'contract.proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                ])->find($id);

        return view('vendor.material.workorder.summariesassigned.show', $data);
    }

    public function updatePosisiIklan(Request $request, $id)
    {
        if(Gate::denies('Summaries Assigned-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $summary = Summary::find($id);
        if($summary->flow_no!=98) {
            abort(403, 'Unauthorized action.');
        }

        $data['summary'] = Summary::with([
                    'summaryitems' => function($query) { $query->where('active', '1')->orderBy('summary_item_termin', 'asc'); }, 
                    'uploadfiles',
                    'contract',
                    'contract.proposal', 
                    'contract.proposal.brand', 
                    'contract.proposal.medias', 
                    'contract.proposal.client', 
                    'contract.proposal.client.clienttype', 
                    'contract.proposal.client_contacts', 
                    'contract.proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                ])->find($id);

        return view('vendor.material.workorder.summariesassigned.update_posisi_iklan', $data);
    }

    public function postUpdatePosisiIklan(Request $request, $id)
    {
        $summary = Summary::find($id);
        $summary->pic = $request->user()->user_id;
        $summary->updated_by = $request->user()->user_id;
        $summary->save();

        $summary_item_id = $request->input('summary_item_id');
        $page_no = $request->input('page_no');
        $summary_item_canal = $request->input('summary_item_canal');
        $summary_item_order_digital = $request->input('summary_item_order_digital');
        $summary_item_materi = $request->input('summary_item_materi');
        $summary_item_status_materi = $request->input('summary_item_status_materi');
        $summary_item_capture_materi = $request->input('summary_item_capture_materi');
        $summary_item_sales_order = $request->input('summary_item_sales_order');
        $summary_item_po_perjanjian = $request->input('summary_item_po_perjanjian');
        $summary_item_ppn = $request->input('summary_item_ppn');
        $summary_item_total = $request->input('summary_item_total');

        foreach($summary_item_id as $key => $value) {
            $item = SummaryItem::find($value);
            $item->page_no = $page_no[$key];
            $item->summary_item_canal = $summary_item_canal[$key];
            $item->summary_item_order_digital = $summary_item_order_digital[$key];
            $item->summary_item_materi = $summary_item_materi[$key];
            $item->summary_item_status_materi = $summary_item_status_materi[$key];
            $item->summary_item_capture_materi = $summary_item_capture_materi[$key];
            $item->summary_item_sales_order = $summary_item_sales_order[$key];
            $item->summary_item_po_perjanjian = $summary_item_po_perjanjian[$key];
            $item->summary_item_ppn = $summary_item_ppn[$key];
            $item->summary_item_total = $summary_item_total[$key];
            $item->summary_item_pic = $request->user()->user_id;
            $item->summary_item_task_status = 0;
            $item->updated_by = $request->user()->user_id;

            $item->save();
        }

        $this->notif->remove($request->user()->user_id, 'summaryassigned', $id);

        $request->session()->flash('status', 'Data has been updated!');
        return redirect('workorder/summariesassigned');
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'updated_at';
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
        $data['rows'] =  Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                ->where('summaries.current_user', '=' , $request->user()->user_id)
                                ->where('summaries.pic', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                ->where('summaries.current_user', '=' , $request->user()->user_id)
                                ->where('summaries.pic', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }
}
