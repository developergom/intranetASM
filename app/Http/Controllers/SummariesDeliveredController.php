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

class SummariesDeliveredController extends Controller
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
        if(Gate::denies('Summaries Delivered-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.workorder.summariesdelivered.list');
    }

    public function show($id)
    {
    	if(Gate::denies('Summaries Delivered-Read')) {
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

        return view('vendor.material.workorder.summariesdelivered.show', $data);
    }

    public function assigned(Request $request,$id)
    {
    	if(Gate::denies('Summaries Delivered-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $ul = new UserLibrary;

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

        $data['pic'] = $ul->getUserSubordinate($request->user()->user_id);

        return view('vendor.material.workorder.summariesdelivered.assigned', $data);
    }

    public function assignedPost(Request $request, $id)
    {
    	$this->validate($request, [
    		'pic' => 'required'
    	]);

    	$summary = Summary::find($id);
    	$summary->pic = $request->input('pic');
    	$summary->current_user = $request->input('pic');
    	$summary->updated_by = $request->user()->user_id;
    	$summary->save();

    	$his = new SummaryHistory;
        $his->summary_id = $id;
        $his->approval_type_id = 2;
        $his->summary_history_text = 'Assigned PIC for Summary';
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'summarydelivered', $id);
        $this->notif->generate($request->user()->user_id, $request->input('pic'), 'summaryassigned', 'Please check Summary ' . $summary->summary_order_no . ' .', $id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('workorder/summariesdelivered');
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
        $data['rows'] =  Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'userpic.user_firstname AS pic_firstname' ,'users.user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->leftJoin('users AS userpic','userpic.user_id', '=', 'summaries.pic')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('userpic.user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('users.user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'userpic.user_firstname AS pic_firstname' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->leftJoin('users AS userpic','userpic.user_id', '=', 'summaries.pic')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('userpic.user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('users.user_firstname','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }
}
