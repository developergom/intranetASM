<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\UploadFile;
use App\ActionPlan;
use App\AdvertisePosition;
use App\AdvertiseRate;
use App\AdvertiseSize;
use App\EventPlan;
use App\InventoryPlanner;
use App\InventoryType;
use App\InventoryPlannerHistory;
use App\InventoryPlannerPrice;
use App\InventoryPlannerPrintPrice;
use App\InventoryPlannerDigitalPrice;
use App\InventoryPlannerCreativePrice;
use App\InventoryPlannerEventPrice;
use App\Implementation;
use App\Media;
use App\MediaGroup;
use App\MediaEdition;
use App\Paper;
use App\PriceType;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class InventoryPlannerController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/inventory/inventoryplanner';
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
        if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

        //dd($this->flows);

        $data = array();

        return view('vendor.material.inventory.inventoryplanner.list', $data);
    }

    public function create(Request $request)
    {
		if(Gate::denies('Inventory Planner-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['inventory_types'] = InventoryType::where('active', '1')->orderBy('inventory_type_name')->get();
        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
	                                $query->where('users_medias.user_id', '=', $request->user()->user_id);
	                            })->where('medias.active', '1')->orderBy('media_name')->get();
        $data['action_plans'] = ActionPlan::where('active', '1')->orderBy('action_plan_title')->get();
        $data['event_plans'] = EventPlan::where('active', '1')->orderBy('event_plan_name')->get();

        $data['advertise_sizes'] = AdvertiseSize::where('active', '1')->orderBy('advertise_size_name')->get();
        $data['advertise_positions'] = AdvertisePosition::where('active', '1')->orderBy('advertise_position_name')->get();
        $data['papers'] = Paper::where('active', '1')->orderBy('paper_name')->get();
        $data['price_types'] = PriceType::where('active', '1')->orderBy('price_type_name')->get();

     	return view('vendor.material.inventory.inventoryplanner.create', $data);   
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        //dd($subordinate);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'inventory_planner_id';
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
            $data['rows'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.current_user')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.active', '=', '1')
                                ->where('inventories_planner.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.current_user')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.active', '=', '1')
                                ->where('inventories_planner.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.flow_no','<>','99')
                                ->where('inventories_planner.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.flow_no','<>','99')
                                ->where('inventories_planner.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }


    public function apiGetMedias(Request $request) {
    	$data = array();

    	$medias = $request->input('medias');

    	$data['media'] = Media::whereIn('media_id', $medias)->where('active', '1')->orderBy('media_name')->get();

    	return response()->json($data);
    }

    public function apiGetRates(Request $request) {
    	$data = array();

    	$media_id = $request->input('media_id');
    	$advertise_position_id = $request->input('advertise_position_id');
    	$advertise_size_id = $request->input('advertise_size_id');
    	$paper_id = $request->input('paper_id');

    	$data['rates'] = AdvertiseRate::where('media_id', $media_id)
    									->where('advertise_position_id', $advertise_position_id)
    									->where('advertise_size_id', $advertise_size_id)
    									->where('paper_id', $paper_id)
    									->where('advertise_rates.active', '1')
    									->orderBy('advertise_rate_code')
    									->get();
    	return response()->json($data);
    }

    public function apiGetBasicRate(Request $request) {
    	$data = array();

    	$advertise_rate_id = $request->input('advertise_rate_id') or 0;
    	if($advertise_rate_id != 0) {
    		$rate = AdvertiseRate::find($advertise_rate_id);

    		$data['basic_rate'] = $rate->advertise_rate_normal;	
    	}else{
    		$data['basic_rate'] = 0;
    	}
    	

    	return $data;
    }

    public function apiLoadPrintPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$data['prices'] = $request->session()->get('inventory_print_prices_' . $request->user()->user_id);

    	return response()->json($data);
    }

    public function apiStorePrintPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Create')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$price_type_id = $request->input('price_type_id');
    	$media_id = $request->input('media_id');
    	$media_name = $request->input('media_name');
    	$advertise_position_id = $request->input('advertise_position_id');
    	$advertise_position_name = $request->input('advertise_position_name');
    	$advertise_size_id = $request->input('advertise_size_id');
    	$advertise_size_name = $request->input('advertise_size_name');
    	$paper_id = $request->input('paper_id');
    	$paper_name = $request->input('paper_name');
    	$advertise_rate_id = $request->input('advertise_rate_id');
    	$advertise_rate_name = $request->input('advertise_rate_name');
    	$inventory_planner_print_price_gross_rate = $request->input('inventory_planner_print_price_gross_rate');
    	$inventory_planner_print_price_surcharge = $request->input('inventory_planner_print_price_surcharge');
    	$inventory_planner_print_price_total_gross_rate = $request->input('inventory_planner_print_price_total_gross_rate');
    	$inventory_planner_print_price_discount = $request->input('inventory_planner_print_price_discount');
    	$inventory_planner_print_price_nett_rate = $request->input('inventory_planner_print_price_nett_rate');
    	$inventory_planner_print_price_remarks = $request->input('inventory_planner_print_price_remarks');

    	$price = array();
    	$price['price_type_id'] = $price_type_id;
    	$price['media_id'] = $media_id;
    	$price['media_name'] = $media_name;
    	$price['advertise_position_id'] = $advertise_position_id;
    	$price['advertise_position_name'] = $advertise_position_name;
    	$price['advertise_size_id'] = $advertise_size_id;
    	$price['advertise_size_name'] = $advertise_size_name;
    	$price['paper_id'] = $paper_id;
    	$price['paper_name'] = $paper_name;
    	$price['advertise_rate_id'] = $advertise_rate_id;
    	$price['advertise_rate_name'] = $advertise_rate_name;
    	$price['inventory_planner_print_price_gross_rate'] = $inventory_planner_print_price_gross_rate;
    	$price['inventory_planner_print_price_surcharge'] = $inventory_planner_print_price_surcharge;
    	$price['inventory_planner_print_price_total_gross_rate'] = $inventory_planner_print_price_total_gross_rate;
    	$price['inventory_planner_print_price_discount'] = $inventory_planner_print_price_discount;
    	$price['inventory_planner_print_price_nett_rate'] = $inventory_planner_print_price_nett_rate;
    	$price['inventory_planner_print_price_remarks'] = $inventory_planner_print_price_remarks;

    	$prices = array();
    	if($request->session()->has('inventory_print_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_print_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_print_prices_' . $request->user()->user_id);
    		$i = count($prices) + 1;
    	}else{
    		$i = 1;
    	}

    	$prices[] = $price;

    	$request->session()->put('inventory_print_prices_' . $request->user()->user_id, $prices);
    	
    	$data['status'] = '200';

    	return response()->json($data);
    }

    public function apiDeletePrintPrices(Request $request) {
    	$data = array();

    	$key = $request->input('key');

    	$prices = array();
    	if($request->session()->has('inventory_print_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_print_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_print_prices_' . $request->user()->user_id);

    		unset($prices[$key]);

    		$request->session()->put('inventory_print_prices_' . $request->user()->user_id, $prices);
    	
	    	$data['status'] = '200';

	    	return response()->json($data);	
    	}else{
    		$data['status'] = '500';

	    	return response()->json($data);
    	}


    }

    public function apiLoadDigitalPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$data['prices'] = $request->session()->get('inventory_digital_prices_' . $request->user()->user_id);

    	return response()->json($data);
    }

    public function apiStoreDigitalPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Create')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$price_type_id = $request->input('price_type_id');
    	$media_id = $request->input('media_id');
    	$media_name = $request->input('media_name');
    	$advertise_position_id = $request->input('advertise_position_id');
    	$advertise_position_name = $request->input('advertise_position_name');
    	$advertise_size_id = $request->input('advertise_size_id');
    	$advertise_size_name = $request->input('advertise_size_name');
    	$paper_id = $request->input('paper_id');
    	$paper_name = $request->input('paper_name');
    	$advertise_rate_id = $request->input('advertise_rate_id');
    	$advertise_rate_name = $request->input('advertise_rate_name');
    	$inventory_planner_digital_price_startdate = $request->input('inventory_planner_digital_price_startdate');
    	$inventory_planner_digital_price_enddate = $request->input('inventory_planner_digital_price_enddate');
    	$inventory_planner_digital_price_deadline = $request->input('inventory_planner_digital_price_deadline');
    	$inventory_planner_digital_price_gross_rate = $request->input('inventory_planner_digital_price_gross_rate');
    	$inventory_planner_digital_price_surcharge = $request->input('inventory_planner_digital_price_surcharge');
    	$inventory_planner_digital_price_total_gross_rate = $request->input('inventory_planner_digital_price_total_gross_rate');
    	$inventory_planner_digital_price_discount = $request->input('inventory_planner_digital_price_discount');
    	$inventory_planner_digital_price_nett_rate = $request->input('inventory_planner_digital_price_nett_rate');
    	$inventory_planner_digital_price_remarks = $request->input('inventory_planner_digital_price_remarks');

    	$price = array();
    	$price['price_type_id'] = $price_type_id;
    	$price['media_id'] = $media_id;
    	$price['media_name'] = $media_name;
    	$price['advertise_position_id'] = $advertise_position_id;
    	$price['advertise_position_name'] = $advertise_position_name;
    	$price['advertise_size_id'] = $advertise_size_id;
    	$price['advertise_size_name'] = $advertise_size_name;
    	$price['paper_id'] = $paper_id;
    	$price['paper_name'] = $paper_name;
    	$price['advertise_rate_id'] = $advertise_rate_id;
    	$price['advertise_rate_name'] = $advertise_rate_name;
    	$price['inventory_planner_digital_price_startdate'] = $inventory_planner_digital_price_startdate;
    	$price['inventory_planner_digital_price_enddate'] = $inventory_planner_digital_price_enddate;
    	$price['inventory_planner_digital_price_deadline'] = $inventory_planner_digital_price_deadline;
    	$price['inventory_planner_digital_price_gross_rate'] = $inventory_planner_digital_price_gross_rate;
    	$price['inventory_planner_digital_price_surcharge'] = $inventory_planner_digital_price_surcharge;
    	$price['inventory_planner_digital_price_total_gross_rate'] = $inventory_planner_digital_price_total_gross_rate;
    	$price['inventory_planner_digital_price_discount'] = $inventory_planner_digital_price_discount;
    	$price['inventory_planner_digital_price_nett_rate'] = $inventory_planner_digital_price_nett_rate;
    	$price['inventory_planner_digital_price_remarks'] = $inventory_planner_digital_price_remarks;

    	$prices = array();
    	if($request->session()->has('inventory_digital_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_digital_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_digital_prices_' . $request->user()->user_id);
    		$i = count($prices) + 1;
    	}else{
    		$i = 1;
    	}

    	$prices[] = $price;

    	$request->session()->put('inventory_digital_prices_' . $request->user()->user_id, $prices);
    	
    	$data['status'] = '200';

    	return response()->json($data);
    }

    public function apiDeleteDigitalPrices(Request $request) {
    	$data = array();

    	$key = $request->input('key');

    	$prices = array();
    	if($request->session()->has('inventory_digital_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_digital_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_digital_prices_' . $request->user()->user_id);

    		unset($prices[$key]);

    		$request->session()->put('inventory_digital_prices_' . $request->user()->user_id, $prices);
    	
	    	$data['status'] = '200';

	    	return response()->json($data);	
    	}else{
    		$data['status'] = '500';

	    	return response()->json($data);
    	}


    }
}
