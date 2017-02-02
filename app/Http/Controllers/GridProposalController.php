<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\GridProposal;
use App\GridProposalHistory;
use App\UploadFile;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class GridProposalController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/grid/proposal';
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
        if(Gate::denies('Grid Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.grid.proposal.list', $data);
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'grid_proposal_id';
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
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.active', '=', '1')
                                ->where('grid_proposals.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.active', '=', '1')
                                ->where('grid_proposals.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.flow_no','<>','99')
                                ->where('grid_proposals.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.flow_no','<>','99')
                                ->where('grid_proposals.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhere('grid_proposals.pic_1', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhere('grid_proposals.pic_2', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhere('grid_proposals.pic_1', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhere('grid_proposals.pic_2', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }
}
