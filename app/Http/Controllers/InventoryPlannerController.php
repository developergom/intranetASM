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
use App\InventoryPlannerOtherPrice;
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

    public function store(Request $request)
    {
        $this->validate($request, [
        	'inventory_type_id' => 'required',
            'inventory_planner_title' => 'required|max:100',
            'inventory_planner_desc' => 'required',
            'inventory_planner_year' => 'required|max:4',
            'inventory_planner_deadline' => 'required|date_format:"d/m/Y"',
            'action_plan_pages' => 'numeric',
            'action_plan_views' => 'numeric',
            'implementation_id[]' => 'array',
            'media_id[]' => 'array',
            'action_plan_id[]' => 'array',
            'event_plan_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new InventoryPlanner;
        $obj->inventory_type_id = $request->input('inventory_type_id');
        $obj->inventory_planner_title = $request->input('inventory_planner_title');
        $obj->inventory_planner_desc = $request->input('inventory_planner_desc');
        $obj->inventory_planner_deadline = Carbon::createFromFormat('d/m/Y', $request->input('inventory_planner_deadline'))->toDateString();
        $obj->inventory_planner_year = $request->input('inventory_planner_year');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->revision_no = 0;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);
        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = 'uploads/files/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = 'uploads/files/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
            }

            if(File::move($value, $newfile)) {
                $file = pathinfo($newfile);
                $filesize = File::size($newfile);

                $upl = new UploadFile;
                $upl->upload_file_type = $file['extension'];
                $upl->upload_file_name = $file['basename'];
                $upl->upload_file_path = $file['dirname'];
                $upl->upload_file_size = $filesize;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => 0 ];
            }
        }

        if(!empty($fileArray)) {
            InventoryPlanner::find($obj->inventory_planner_id)->uploadfiles()->sync($fileArray);    
        }

        if(!empty($request->input('implementation_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->implementations()->sync($request->input('implementation_id'));
        }

        if(!empty($request->input('media_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->medias()->sync($request->input('media_id'));
        }
        
        if(!empty($request->input('action_plan_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->actionplans()->sync($request->input('action_plan_id'));
        }

        if(!empty($request->input('event_plan_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->eventplans()->sync($request->input('event_plan_id'));
        }

        $his = new InventoryPlannerHistory;
        $his->inventory_planner_id = $obj->inventory_planner_id;
        $his->approval_type_id = 1;
        $his->inventory_planner_history_text = $request->input('inventory_planner_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        //store print price items
        if($request->session()->has('inventory_print_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_print_prices_' . $request->user()->user_id);
    		foreach($prices as $price) {
    			$ippp = new InventoryPlannerPrintPrice;
    			$ippp->inventory_planner_id = $obj->inventory_planner_id;
    			$ippp->price_type_id = $price['price_type_id'];
    			$ippp->media_id = $price['media_id'];
    			/*$ippp->media_edition_id = $price->media_edition_id;*/
    			$ippp->advertise_rate_id = $price['advertise_rate_id'];
    			$ippp->inventory_planner_print_price_remarks = $price['inventory_planner_print_price_remarks'];
    			$ippp->inventory_planner_print_price_gross_rate = $price['inventory_planner_print_price_gross_rate'];
    			$ippp->inventory_planner_print_price_surcharge = $price['inventory_planner_print_price_surcharge'];
    			$ippp->inventory_planner_print_price_total_gross_rate = $price['inventory_planner_print_price_total_gross_rate'];
    			$ippp->inventory_planner_print_price_discount = $price['inventory_planner_print_price_discount'];
    			$ippp->inventory_planner_print_price_nett_rate = $price['inventory_planner_print_price_nett_rate'];
    			$ippp->active = '1';
    			$ippp->created_by = $request->user()->user_id;

    			$ippp->save();
    		}

    		$request->session()->forget('inventory_print_prices_' . $request->user()->user_id);
    	}

    	//store digital price items
    	if($request->session()->has('inventory_digital_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_digital_prices_' . $request->user()->user_id);
    		foreach($prices as $price) {
    			$ipdp = new InventoryPlannerDigitalPrice;
    			$ipdp->inventory_planner_id = $obj->inventory_planner_id;
    			$ipdp->price_type_id = $price['price_type_id'];
    			$ipdp->media_id = $price['media_id'];
    			$ipdp->advertise_rate_id = $price['advertise_rate_id'];
    			$ipdp->inventory_planner_digital_price_startdate = Carbon::createFromFormat('d/m/Y', $price['inventory_planner_digital_price_startdate'])->toDateString();
    			$ipdp->inventory_planner_digital_price_enddate = Carbon::createFromFormat('d/m/Y', $price['inventory_planner_digital_price_enddate'])->toDateString();
    			$ipdp->inventory_planner_digital_price_deadline = Carbon::createFromFormat('d/m/Y', $price['inventory_planner_digital_price_deadline'])->toDateString();
    			$ipdp->inventory_planner_digital_price_remarks = $price['inventory_planner_digital_price_remarks'];
    			$ipdp->inventory_planner_digital_price_gross_rate = $price['inventory_planner_digital_price_gross_rate'];
    			$ipdp->inventory_planner_digital_price_surcharge = $price['inventory_planner_digital_price_surcharge'];
    			$ipdp->inventory_planner_digital_price_total_gross_rate = $price['inventory_planner_digital_price_total_gross_rate'];
    			$ipdp->inventory_planner_digital_price_discount = $price['inventory_planner_digital_price_discount'];
    			$ipdp->inventory_planner_digital_price_nett_rate = $price['inventory_planner_digital_price_nett_rate'];
    			$ipdp->active = '1';
    			$ipdp->created_by = $request->user()->user_id;

    			$ipdp->save();
    		}

    		$request->session()->forget('inventory_digital_prices_' . $request->user()->user_id);
    	}

    	//store event price items
    	if($request->session()->has('inventory_event_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_event_prices_' . $request->user()->user_id);
    		foreach($prices as $price) {
    			$ipdp = new InventoryPlannerEventPrice;
    			$ipdp->inventory_planner_id = $obj->inventory_planner_id;
    			$ipdp->price_type_id = $price['price_type_id'];
    			$ipdp->media_id = $price['media_id'];
    			$ipdp->inventory_planner_event_price_remarks = $price['inventory_planner_event_price_remarks'];
    			$ipdp->inventory_planner_event_price_gross_rate = $price['inventory_planner_event_price_gross_rate'];
    			$ipdp->inventory_planner_event_price_surcharge = $price['inventory_planner_event_price_surcharge'];
    			$ipdp->inventory_planner_event_price_total_gross_rate = $price['inventory_planner_event_price_total_gross_rate'];
    			$ipdp->inventory_planner_event_price_discount = $price['inventory_planner_event_price_discount'];
    			$ipdp->inventory_planner_event_price_nett_rate = $price['inventory_planner_event_price_nett_rate'];
    			$ipdp->active = '1';
    			$ipdp->created_by = $request->user()->user_id;

    			$ipdp->save();
    		}

    		$request->session()->forget('inventory_event_prices_' . $request->user()->user_id);
    	}

    	//store creative price items
        if($request->session()->has('inventory_creative_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_creative_prices_' . $request->user()->user_id);
    		foreach($prices as $price) {
    			$ippp = new InventoryPlannerCreativePrice;
    			$ippp->inventory_planner_id = $obj->inventory_planner_id;
    			$ippp->price_type_id = $price['price_type_id'];
    			$ippp->media_id = $price['media_id'];
    			$ippp->advertise_rate_id = $price['advertise_rate_id'];
    			$ippp->inventory_planner_creative_price_remarks = $price['inventory_planner_creative_price_remarks'];
    			$ippp->inventory_planner_creative_price_gross_rate = $price['inventory_planner_creative_price_gross_rate'];
    			$ippp->inventory_planner_creative_price_surcharge = $price['inventory_planner_creative_price_surcharge'];
    			$ippp->inventory_planner_creative_price_total_gross_rate = $price['inventory_planner_creative_price_total_gross_rate'];
    			$ippp->inventory_planner_creative_price_discount = $price['inventory_planner_creative_price_discount'];
    			$ippp->inventory_planner_creative_price_nett_rate = $price['inventory_planner_creative_price_nett_rate'];
    			$ippp->active = '1';
    			$ippp->created_by = $request->user()->user_id;

    			$ippp->save();
    		}

    		$request->session()->forget('inventory_creative_prices_' . $request->user()->user_id);
    	}

    	//store other price items
    	if($request->session()->has('inventory_other_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_other_prices_' . $request->user()->user_id);
    		foreach($prices as $price) {
    			$ipdp = new InventoryPlannerOtherPrice;
    			$ipdp->inventory_planner_id = $obj->inventory_planner_id;
    			$ipdp->price_type_id = $price['price_type_id'];
    			$ipdp->media_id = $price['media_id'];
    			$ipdp->inventory_planner_other_price_remarks = $price['inventory_planner_other_price_remarks'];
    			$ipdp->inventory_planner_other_price_gross_rate = $price['inventory_planner_other_price_gross_rate'];
    			$ipdp->inventory_planner_other_price_surcharge = $price['inventory_planner_other_price_surcharge'];
    			$ipdp->inventory_planner_other_price_total_gross_rate = $price['inventory_planner_other_price_total_gross_rate'];
    			$ipdp->inventory_planner_other_price_discount = $price['inventory_planner_other_price_discount'];
    			$ipdp->inventory_planner_other_price_nett_rate = $price['inventory_planner_other_price_nett_rate'];
    			$ipdp->active = '1';
    			$ipdp->created_by = $request->user()->user_id;

    			$ipdp->save();
    		}

    		$request->session()->forget('inventory_other_prices_' . $request->user()->user_id);
    	}

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'inventoryplannerapproval', 'Please check Inventory Planner "' . $obj->inventory_planner_title . '"', $obj->inventory_planner_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('inventory/inventoryplanner');
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

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

    	//$advertise_rate_id = $request->input('advertise_rate_id') or 0;
    	$advertise_rate_id = $request->input('advertise_rate_id');
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


    public function apiLoadEventPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$data['prices'] = $request->session()->get('inventory_event_prices_' . $request->user()->user_id);

    	return response()->json($data);
    }

    public function apiStoreEventPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Create')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$price_type_id = $request->input('price_type_id');
    	$media_id = $request->input('media_id');
    	$media_name = $request->input('media_name');
    	$inventory_planner_event_price_gross_rate = $request->input('inventory_planner_event_price_gross_rate');
    	$inventory_planner_event_price_surcharge = $request->input('inventory_planner_event_price_surcharge');
    	$inventory_planner_event_price_total_gross_rate = $request->input('inventory_planner_event_price_total_gross_rate');
    	$inventory_planner_event_price_discount = $request->input('inventory_planner_event_price_discount');
    	$inventory_planner_event_price_nett_rate = $request->input('inventory_planner_event_price_nett_rate');
    	$inventory_planner_event_price_remarks = $request->input('inventory_planner_event_price_remarks');

    	$price = array();
    	$price['price_type_id'] = $price_type_id;
    	$price['media_id'] = $media_id;
    	$price['media_name'] = $media_name;
    	$price['inventory_planner_event_price_gross_rate'] = $inventory_planner_event_price_gross_rate;
    	$price['inventory_planner_event_price_surcharge'] = $inventory_planner_event_price_surcharge;
    	$price['inventory_planner_event_price_total_gross_rate'] = $inventory_planner_event_price_total_gross_rate;
    	$price['inventory_planner_event_price_discount'] = $inventory_planner_event_price_discount;
    	$price['inventory_planner_event_price_nett_rate'] = $inventory_planner_event_price_nett_rate;
    	$price['inventory_planner_event_price_remarks'] = $inventory_planner_event_price_remarks;

    	$prices = array();
    	if($request->session()->has('inventory_event_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_event_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_event_prices_' . $request->user()->user_id);
    		$i = count($prices) + 1;
    	}else{
    		$i = 1;
    	}

    	$prices[] = $price;

    	$request->session()->put('inventory_event_prices_' . $request->user()->user_id, $prices);
    	
    	$data['status'] = '200';

    	return response()->json($data);
    }

    public function apiDeleteEventPrices(Request $request) {
    	$data = array();

    	$key = $request->input('key');

    	$prices = array();
    	if($request->session()->has('inventory_event_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_event_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_event_prices_' . $request->user()->user_id);

    		unset($prices[$key]);

    		$request->session()->put('inventory_event_prices_' . $request->user()->user_id, $prices);
    	
	    	$data['status'] = '200';

	    	return response()->json($data);	
    	}else{
    		$data['status'] = '500';

	    	return response()->json($data);
    	}


    }


    public function apiLoadCreativePrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$data['prices'] = $request->session()->get('inventory_creative_prices_' . $request->user()->user_id);

    	return response()->json($data);
    }

    public function apiStoreCreativePrices(Request $request) {
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
    	$inventory_planner_creative_price_gross_rate = $request->input('inventory_planner_creative_price_gross_rate');
    	$inventory_planner_creative_price_surcharge = $request->input('inventory_planner_creative_price_surcharge');
    	$inventory_planner_creative_price_total_gross_rate = $request->input('inventory_planner_creative_price_total_gross_rate');
    	$inventory_planner_creative_price_discount = $request->input('inventory_planner_creative_price_discount');
    	$inventory_planner_creative_price_nett_rate = $request->input('inventory_planner_creative_price_nett_rate');
    	$inventory_planner_creative_price_remarks = $request->input('inventory_planner_creative_price_remarks');

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
    	$price['inventory_planner_creative_price_gross_rate'] = $inventory_planner_creative_price_gross_rate;
    	$price['inventory_planner_creative_price_surcharge'] = $inventory_planner_creative_price_surcharge;
    	$price['inventory_planner_creative_price_total_gross_rate'] = $inventory_planner_creative_price_total_gross_rate;
    	$price['inventory_planner_creative_price_discount'] = $inventory_planner_creative_price_discount;
    	$price['inventory_planner_creative_price_nett_rate'] = $inventory_planner_creative_price_nett_rate;
    	$price['inventory_planner_creative_price_remarks'] = $inventory_planner_creative_price_remarks;

    	$prices = array();
    	if($request->session()->has('inventory_creative_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_creative_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_creative_prices_' . $request->user()->user_id);
    		$i = count($prices) + 1;
    	}else{
    		$i = 1;
    	}

    	$prices[] = $price;

    	$request->session()->put('inventory_creative_prices_' . $request->user()->user_id, $prices);
    	
    	$data['status'] = '200';

    	return response()->json($data);
    }

    public function apiDeleteCreativePrices(Request $request) {
    	$data = array();

    	$key = $request->input('key');

    	$prices = array();
    	if($request->session()->has('inventory_creative_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_creative_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_creative_prices_' . $request->user()->user_id);

    		unset($prices[$key]);

    		$request->session()->put('inventory_creative_prices_' . $request->user()->user_id, $prices);
    	
	    	$data['status'] = '200';

	    	return response()->json($data);	
    	}else{
    		$data['status'] = '500';

	    	return response()->json($data);
    	}


    }

    public function apiLoadOtherPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$data['prices'] = $request->session()->get('inventory_other_prices_' . $request->user()->user_id);

    	return response()->json($data);
    }

    public function apiStoreOtherPrices(Request $request) {
    	if(Gate::denies('Inventory Planner-Create')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$price_type_id = $request->input('price_type_id');
    	$media_id = $request->input('media_id');
    	$media_name = $request->input('media_name');
    	$inventory_planner_other_price_gross_rate = $request->input('inventory_planner_other_price_gross_rate');
    	$inventory_planner_other_price_surcharge = $request->input('inventory_planner_other_price_surcharge');
    	$inventory_planner_other_price_total_gross_rate = $request->input('inventory_planner_other_price_total_gross_rate');
    	$inventory_planner_other_price_discount = $request->input('inventory_planner_other_price_discount');
    	$inventory_planner_other_price_nett_rate = $request->input('inventory_planner_other_price_nett_rate');
    	$inventory_planner_other_price_remarks = $request->input('inventory_planner_other_price_remarks');

    	$price = array();
    	$price['price_type_id'] = $price_type_id;
    	$price['media_id'] = $media_id;
    	$price['media_name'] = $media_name;
    	$price['inventory_planner_other_price_gross_rate'] = $inventory_planner_other_price_gross_rate;
    	$price['inventory_planner_other_price_surcharge'] = $inventory_planner_other_price_surcharge;
    	$price['inventory_planner_other_price_total_gross_rate'] = $inventory_planner_other_price_total_gross_rate;
    	$price['inventory_planner_other_price_discount'] = $inventory_planner_other_price_discount;
    	$price['inventory_planner_other_price_nett_rate'] = $inventory_planner_other_price_nett_rate;
    	$price['inventory_planner_other_price_remarks'] = $inventory_planner_other_price_remarks;

    	$prices = array();
    	if($request->session()->has('inventory_other_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_other_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_other_prices_' . $request->user()->user_id);
    		$i = count($prices) + 1;
    	}else{
    		$i = 1;
    	}

    	$prices[] = $price;

    	$request->session()->put('inventory_other_prices_' . $request->user()->user_id, $prices);
    	
    	$data['status'] = '200';

    	return response()->json($data);
    }

    public function apiDeleteOtherPrices(Request $request) {
    	$data = array();

    	$key = $request->input('key');

    	$prices = array();
    	if($request->session()->has('inventory_other_prices_' . $request->user()->user_id)) {
    		$prices = $request->session()->get('inventory_other_prices_' . $request->user()->user_id);
    		$request->session()->forget('inventory_other_prices_' . $request->user()->user_id);

    		unset($prices[$key]);

    		$request->session()->put('inventory_other_prices_' . $request->user()->user_id, $prices);
    	
	    	$data['status'] = '200';

	    	return response()->json($data);	
    	}else{
    		$data['status'] = '500';

	    	return response()->json($data);
    	}


    }
}
