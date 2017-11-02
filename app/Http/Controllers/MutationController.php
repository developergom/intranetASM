<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Gate;
use App\Http\Requests;
use App\Contract;
use App\InventoryPlanner;
use App\Module;
use App\Mutation;
use App\Proposal;
use App\Summary;
use App\User;

class MutationController extends Controller
{
	private $proposal_uri = '/workorder/proposal';
	private $inventory_uri = '/inventory/inventoryplanner';
    private $contract_uri = '/workorder/contract';
	private $summary_uri = '/workorder/summary';

	private $proposal_module_id = 0;
	private $inventory_module_id = 0;
    private $summary_module_id = 0;
	private $contract_module_id = 0;

	public function __construct(){
		$proposal = Module::where('module_url', $this->proposal_uri)->first();
		$inventory = Module::where('module_url', $this->inventory_uri)->first();
        $contract = Module::where('module_url', $this->contract_uri)->first();
		$summary = Module::where('module_url', $this->summary_uri)->first();

		//dd($proposal);

		$this->proposal_module_id = $proposal->module_id;
		$this->inventory_module_id = $inventory->module_id;
        $this->contract_module_id = $contract->module_id;
		$this->summary_module_id = $summary->module_id;
	}
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
            'mutation_from' => 'required',
            'inventory_assign_to' => 'array',
            'proposal_assign_to' => 'array',
            'summary_assign_to' => 'array',
            'mutation_desc' => 'required',
        ]);

        //dd($request->all());
        $inventories = $request->input('inventory_planner_id');
        $inventory_assign_to = $request->input('inventory_assign_to');
        if(count($inventories) > 0) {
        	foreach($inventories as $key => $value) {
	        	$obj = InventoryPlanner::find($value);
	        	if($obj->current_user==$obj->created_by) {
	        		$obj->current_user = $inventory_assign_to[$key];
	        	}
	        	$obj->created_by = $inventory_assign_to[$key];
	        	$obj->save();

	        	$mut = new Mutation;
	        	$mut->mutation_from = $request->input('mutation_from');
	        	$mut->mutation_to = $inventory_assign_to[$key];
	        	$mut->mutation_desc = $request->input('mutation_desc');
	        	$mut->module_id = $this->inventory_module_id;
	        	$mut->mutation_item_id = $value;
	        	$mut->active = '1';
	        	$mut->created_by = $request->user()->user_id;
	        	$mut->save();
	        }
        }
        
        $proposals = $request->input('proposal_id');
        $proposal_assign_to = $request->input('proposal_assign_to');
        if(count($proposals) > 0) {
        	foreach($proposals as $key => $value) {
	        	$obj = Proposal::find($value);
	        	//dd($obj);
	        	if($obj->current_user===$obj->created_by) {
	        		$obj->current_user = $proposal_assign_to[$key];
	        	}
	        	$obj->created_by = $proposal_assign_to[$key];
	        	$obj->save();

	        	$mut = new Mutation;
	        	$mut->mutation_from = $request->input('mutation_from');
	        	$mut->mutation_to = $proposal_assign_to[$key];
	        	$mut->mutation_desc = $request->input('mutation_desc');
	        	$mut->module_id = $this->proposal_module_id;
	        	$mut->mutation_item_id = $value;
	        	$mut->active = '1';
	        	$mut->created_by = $request->user()->user_id;
	        	$mut->save();
	        }
        }

        $contracts = $request->input('contract_id');
        $contract_assign_to = $request->input('contract_assign_to');
        if(count($contracts) > 0) {
            foreach($contracts as $key => $value) {
                $obj = Contract::find($value);
                if($obj->current_user===$obj->created_by) {
                    $obj->current_user = $contract_assign_to[$key];
                }
                $obj->created_by = $contract_assign_to[$key];
                $obj->save();

                $mut = new Mutation;
                $mut->mutation_from = $request->input('mutation_from');
                $mut->mutation_to = $contract_assign_to[$key];
                $mut->mutation_desc = $request->input('mutation_desc');
                $mut->module_id = $this->contract_module_id;
                $mut->mutation_item_id = $value;
                $mut->active = '1';
                $mut->created_by = $request->user()->user_id;
                $mut->save();
            }
        }

        $summaries = $request->input('summary_id');
        $summary_assign_to = $request->input('summary_assign_to');
        if(count($summaries) > 0) {
        	foreach($summaries as $key => $value) {
	        	$obj = Summary::find($value);
	        	if($obj->current_user===$obj->created_by) {
	        		$obj->current_user = $summary_assign_to[$key];
	        	}
	        	$obj->created_by = $summary_assign_to[$key];
	        	$obj->save();

	        	$mut = new Mutation;
	        	$mut->mutation_from = $request->input('mutation_from');
	        	$mut->mutation_to = $summary_assign_to[$key];
	        	$mut->mutation_desc = $request->input('mutation_desc');
	        	$mut->module_id = $this->summary_module_id;
	        	$mut->mutation_item_id = $value;
	        	$mut->active = '1';
	        	$mut->created_by = $request->user()->user_id;
	        	$mut->save();
	        }
        }

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('config/mutation');
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
        $data['rows'] = Mutation::select('mutation_id', 'mutations.created_at AS created_at', 'a.user_firstname AS from_firstname', 'a.user_lastname AS from_lastname', 'b.user_firstname AS to_firstname', 'b.user_lastname AS to_lastname', 'inventory_planner_title', 'proposal_name', 'contract_no', 'summary_order_no')
        					->join('users AS a', 'a.user_id', '=', 'mutations.mutation_from')
        					->join('users AS b', 'b.user_id', '=', 'mutations.mutation_to')
        					->leftJoin('inventories_planner', 'inventories_planner.inventory_planner_id', '=', 'mutation_item_id')
        					->leftJoin('proposals', 'proposals.proposal_id', '=', 'mutation_item_id')
                            ->leftJoin('contracts', 'contracts.contract_id', '=', 'mutation_item_id')
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
        $data['total'] = Mutation::select('mutation_id', 'mutations.created_at AS created_at', 'a.user_firstname AS from_firstname', 'a.user_lastname AS from_lastname', 'b.user_firstname AS to_firstname', 'b.user_lastname AS to_lastname', 'inventory_planner_title', 'proposal_name', 'contract_no', 'summary_order_no')
        					->join('users AS a', 'a.user_id', '=', 'mutations.mutation_from')
        					->join('users AS b', 'b.user_id', '=', 'mutations.mutation_to')
        					->leftJoin('inventories_planner', 'inventories_planner.inventory_planner_id', '=', 'mutation_item_id')
        					->leftJoin('proposals', 'proposals.proposal_id', '=', 'mutation_item_id')
                            ->leftJoin('contracts', 'contracts.contract_id', '=', 'mutation_item_id')
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

        $data['contracts'] = Contract::where('created_by', $mutation_from)
                                                        ->where('active', '1')
                                                        ->where('flow_no', '<>', '98')
                                                        ->get();

    	$data['summaries'] = Summary::where('created_by', $mutation_from)
    													->where('active', '1')
    													->where('flow_no', '<>', '98')
    													->get();

    	$logged_in_user = User::with('groups', 'roles')->find($mutation_from);

    	$groups_user = [];
    	foreach ($logged_in_user->groups as $value) {
    		array_push($groups_user, $value->group_id);
    	}

    	$roles_user = [];
    	foreach ($logged_in_user->roles as $value) {
    		array_push($roles_user, $value->role_id);
    	}

    	$data['users'] = User::whereHas('groups', function($query) use($groups_user){
    		$query->whereIn('groups.group_id', $groups_user);
    	})->whereHas('roles', function($query) use($roles_user){
    		$query->whereIn('roles.role_id', $roles_user);
    	})->where('users.active', '1')
    	->orderBy('user_firstname')->get();
    	//dd($logged_in_user->groups[0]);

    	return response()->json($data);
    }
}
