<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\UploadFile;
use App\AdvertisePosition;
use App\AdvertiseRate;
use App\AdvertiseSize;
use App\InventoryPlanner;
use App\Media;
use App\MediaGroup;
use App\MediaEdition;
use App\Paper;
use App\PriceType;
use App\Proposal;
use App\ProposalHistory;
use App\ProposalPrintPrice;
use App\ProposalDigitalPrice;
use App\ProposalCreativePrice;
use App\ProposalEventPrice;
use App\ProposalOtherPrice;
use App\ProposalStatus;
use App\ProposalType;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class ProposalController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/workorder/proposal';
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
        if(Gate::denies('Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        //dd($this->flows);

        $data = array();

        return view('vendor.material.workorder.proposal.list', $data);
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'proposal_id';
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

        if($listtype == 'onprocess') {
            $data['rows'] = Proposal::join('users','users.user_id', '=', 'proposals.current_user')
                                ->where('proposals.flow_no','<>','98')
                                ->where('proposals.active', '=', '1')
                                ->where('proposals.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Proposal::join('users','users.user_id', '=', 'proposals.current_user')
                                ->where('proposals.flow_no','<>','98')
                                ->where('proposals.active', '=', '1')
                                ->where('proposals.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = Proposal::join('users','users.user_id', '=', 'proposals.created_by')
                                ->where('proposals.active','1')
                                ->where('proposals.flow_no','<>','98')
                                ->where('proposals.flow_no','<>','99')
                                ->where('proposals.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Proposal::join('users','users.user_id', '=', 'proposals.created_by')
                                ->where('proposals.active','1')
                                ->where('proposals.flow_no','<>','98')
                                ->where('proposals.flow_no','<>','99')
                                ->where('proposals.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = Proposal::join('users','users.user_id', '=', 'proposals.created_by')
                                ->where('proposals.active','1')
                                ->where('proposals.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Proposal::join('users','users.user_id', '=', 'proposals.created_by')
                                ->where('proposals.active','1')
                                ->where('proposals.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = Proposal::join('users','users.user_id', '=', 'proposals.created_by')
                                ->where('proposals.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Proposal::join('users','users.user_id', '=', 'proposals.created_by')
                                ->where('proposals.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }
}
