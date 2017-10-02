<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\InventoryPlanner;
use App\Mutation;
use App\Proposal;
use App\Summary;
use App\User;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Mutations Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.config.mutation.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Mutations Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['users'] = User::where('active', '1')->orderBy('user_firstname', 'asc')->get();

        return view('vendor.material.config.mutation.create', $data);
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
            'publisher_code' => 'required|max:5|unique:publishers,publisher_code',
            'publisher_name' => 'required|max:100',
        ]);

        $obj = new Publisher;

        $obj->publisher_code = $request->input('publisher_code');
        $obj->publisher_name = $request->input('publisher_name');
        $obj->publisher_desc = $request->input('publisher_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/publisher');
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'mutation_id';
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
        $data['rows'] = Mutation::select('mutation_id', 'mutations.created_at', 'a.user_firstname AS from_firstname', 'a.user_lastname AS from_lastname', 'b.user_firstname AS to_firstname', 'b.user_lastname AS to_lastname', 'inventory_planner_title', 'proposal_name', 'summary_order_no')
        					->join('users AS a', 'a.user_id', '=', 'mutations.mutation_from')
        					->join('users AS b', 'b.user_id', '=', 'mutations.mutation_to')
        					->leftJoin('inventories_planner', 'inventories_planner.inventory_planner_id', '=', 'mutation_item_id')
        					->leftJoin('proposals', 'proposals.proposal_id', '=', 'mutation_item_id')
        					->leftJoin('summaries', 'summaries.summary_id', '=', 'mutation_item_id')
        					->where('mutations.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('a.user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('a.user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('b.user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('b.user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('summary_order_no','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Mutation::select('mutation_id', 'mutations.created_at', 'a.user_firstname AS from_firstname', 'a.user_lastname AS from_lastname', 'b.user_firstname AS to_firstname', 'b.user_lastname AS to_lastname', 'inventory_planner_title', 'proposal_name', 'summary_order_no')
        					->join('users AS a', 'a.user_id', '=', 'mutations.mutation_from')
        					->join('users AS b', 'b.user_id', '=', 'mutations.mutation_to')
        					->leftJoin('inventories_planner', 'inventories_planner.inventory_planner_id', '=', 'mutation_item_id')
        					->leftJoin('proposals', 'proposals.proposal_id', '=', 'mutation_item_id')
        					->leftJoin('summaries', 'summaries.summary_id', '=', 'mutation_item_id')
        					->where('mutations.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('a.user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('a.user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('b.user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('b.user_lastname','like','%' . $searchPhrase . '%')
                                        ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('summary_order_no','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }

    public function apiLoadTasks(Request $request)
    {
    	$data = array();
    	$mutation_from = $request->mutation_from;

    	$data['inventories_planner'] = InventoryPlanner::where('created_by', $mutation_from)
    													->where('active', '1')
    													->where('flow_no', '<>', '98')
    													->get();

    	$data['proposals'] = Proposal::where('created_by', $mutation_from)
    													->where('active', '1')
    													->where('flow_no', '<>', '98')
    													->get();

    	$data['summaries'] = Summary::where('created_by', $mutation_from)
    													->where('active', '1')
    													->where('flow_no', '<>', '98')
    													->get();

    	return response()->json($data);
    }
}
