<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\UploadFile;
use App\Client;
use App\ClientContact;
use App\Flow;
use App\Media;
use App\OmzetType;
use App\PO;
use App\Proposal;
use App\ProposalHistory;
use App\Summary;
use App\SummaryItem;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\GeneratorLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class SummaryController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/workorder/summary';
    private $notif;

    public function __construct() {
        $flow = new FlowLibrary;
        $this->flows = $flow->getCurrentFlows($this->uri);
        $this->flow_group_id = $this->flows[0]->flow_group_id;

        $this->notif = new NotificationLibrary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Summary-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.workorder.summary.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($proposal_id)
    {
        $data['proposal'] = Proposal::with(
                                        'proposaltype', 
                                        'proposalmethod', 
                                        'proposalstatus',
                                        'industries', 
                                        'client_contacts',
                                        'client',
                                        'brand',
                                        'medias',
                                        'uploadfiles',
                                        'inventoriesplanner'
                                        )->find($proposal_id);

        return view('vendor.material.workorder.summary.create', $data);
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
        //dd($request->all(), false);

        dd($request->session()->get('summary_details_' . $request->user()->user_id));
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

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'updated_at';
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

        if($listtype == 'onprocess') {
            $data['rows'] = Summary::select('summaries.summary_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.current_user')
                                ->where('summaries.flow_no','<>','98')
                                ->where('summaries.active', '=', '1')
                                ->where('summaries.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate)
                                            ->orWhere('summaries.pic', $request->user()->user_id)
                                            ->orWhereIn('summaries.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.current_user')
                                ->where('summaries.flow_no','<>','98')
                                ->where('summaries.active', '=', '1')
                                ->where('summaries.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate)
                                            ->orWhere('summaries.pic', $request->user()->user_id)
                                            ->orWhereIn('summaries.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = Summary::select('summaries.summary_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.current_user')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','<>','98')
                                ->where('summaries.flow_no','<>','99')
                                ->where('summaries.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.current_user')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','<>','98')
                                ->where('summaries.flow_no','<>','99')
                                ->where('summaries.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] =  Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'summaries.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }

    public function apiSaveDetails(Request $request)
    {
        //dd($request->input('details'));

        $details = $request->input('details');

        if($request->session()->has('summary_details_' . $request->user()->user_id)) {
            $request->session()->forget('summary_details_' . $request->user()->user_id);
        }

        $request->session()->put('summary_details_' . $request->user()->user_id, $details);
    }
}
