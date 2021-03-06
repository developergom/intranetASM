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
use App\InventoryCategory;
use App\InventoryPlanner;
use App\InventorySource;
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
use App\ProposalType;
use App\SellPeriod;
use App\User;
use App\InventoryPlannerCostDetails;

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
    public function index(Request $request)
    {
        if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['inventory_categories'] = InventoryCategory::where('active', '1')->orderBy('inventory_category_name')->get();
        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                                    $query->where('users_medias.user_id', '=', $request->user()->user_id);
                                })->where('medias.active', '1')->orderBy('media_name')->get();
        $data['years'] = [date('Y')+1,date('Y'), date('Y')-1, date('Y')-2];

        return view('vendor.material.inventory.inventoryplanner.list', $data);
    }

    public function create(Request $request)
    {
		if(Gate::denies('Inventory Planner-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal_types'] = ProposalType::where('active', '1')->orderBy('proposal_type_name')->get();
        $data['inventory_categories'] = InventoryCategory::where('active', '1')->orderBy('inventory_category_name')->get();
        $data['inventory_sources'] = InventorySource::where('active', '1')->orderBy('inventory_source_name')->get();
        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();
        $data['sell_periods'] = SellPeriod::where('active', '1')->orderBy('sell_period_month')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
	                                $query->where('users_medias.user_id', '=', $request->user()->user_id);
	                            })->where('medias.active', '1')->orderBy('media_name')->get();

        $data['advertise_sizes'] = AdvertiseSize::where('active', '1')->orderBy('advertise_size_name')->get();
        $data['advertise_positions'] = AdvertisePosition::where('active', '1')->orderBy('advertise_position_name')->get();
        $data['papers'] = Paper::where('active', '1')->orderBy('paper_name')->get();
        $data['price_types'] = PriceType::where('active', '1')->orderBy('price_type_name')->get();

     	return view('vendor.material.inventory.inventoryplanner.create', $data);   
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'proposal_type_id' => 'required',
            'inventory_category_id[]' => 'array',
        	'inventory_source_id' => 'required',
            'inventory_planner_title' => 'required|max:100',
            'inventory_planner_desc' => 'required',
            /*'inventory_planner_cost' => 'required|numeric',
            'inventory_planner_media_cost_print' => 'required|numeric',
            'inventory_planner_media_cost_other' => 'required|numeric',
            'inventory_planner_total_offering' => 'required|numeric',*/
            'offering_post_cost[]' => 'array',
            'offering_post_media_cost_print[]' => 'array',
            'offering_post_media_cost_other[]' => 'array',
            'offering_post_total_offering[]' => 'array',
            'implementation_post_id[]' => 'array',
            'implementation_post_year[]' => 'array',
            'sell_period_post_id[]' => 'array',
            'sell_period_post_year[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);
        
        $obj = new InventoryPlanner;
        $obj->proposal_type_id = $request->input('proposal_type_id');
        $obj->inventory_source_id = $request->input('inventory_source_id');
        $obj->inventory_planner_title = $request->input('inventory_planner_title');
        $obj->inventory_planner_desc = $request->input('inventory_planner_desc');
        $obj->inventory_planner_cost = 0;
        $obj->inventory_planner_media_cost_print = 0;
        $obj->inventory_planner_media_cost_other = 0;
        $obj->inventory_planner_total_offering = 0;
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->revision_no = 0;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id; 
        $obj->save(); 
        
        //Saving Cost Details
        $data = $request->except('_token');
        $costCount = count($data['offering_post_cost']);
        for($i=0; $i < $costCount; $i++){
 
            $costDetails = new InventoryPlannerCostDetails;
            $costDetails->inventory_planner_id = $obj->inventory_planner_id;
            $costDetails->inventory_planner_cost = $data['offering_post_cost'][$i];
            $costDetails->inventory_planner_media_cost_print = $data['offering_post_media_cost_print'][$i];
            $costDetails->inventory_planner_media_cost_other = $data['offering_post_media_cost_other'][$i];
            $costDetails->inventory_planner_total_offering = $data['offering_post_total_offering'][$i];
            $costDetails->revision_no = 0;
            $costDetails->save();
        }

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
                $upl->upload_file_revision = 0;
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

        if(!empty($request->input('inventory_category_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->inventorycategories()->sync($request->input('inventory_category_id'));
        }

        if(!empty($request->input('implementation_post_id'))) {
            $implementation_sync = array();
            $implementation_post_id = $request->input('implementation_post_id');
            $implementation_post_year = $request->input('implementation_post_year');
            foreach($implementation_post_id as $key => $value)
            {
                array_push($implementation_sync, $value);
                $implementation_sync[$value] = [ 'year' => $implementation_post_year[$key] ];
            }

            InventoryPlanner::find($obj->inventory_planner_id)->implementations()->sync($implementation_sync);
        }

        if(!empty($request->input('sell_period_post_id'))) {
            $sell_period_sync = array();
            $sell_period_post_id = $request->input('sell_period_post_id');
            $sell_period_post_year = $request->input('sell_period_post_year');
            foreach($sell_period_post_id as $key => $value)
            {
                array_push($sell_period_sync, $value);
                $sell_period_sync[$value] = [ 'year' => $sell_period_post_year[$key] ];
            }

            InventoryPlanner::find($obj->inventory_planner_id)->sellperiods()->sync($sell_period_sync);
        }

        if(!empty($request->input('media_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->medias()->sync($request->input('media_id'));
        }

        

        $his = new InventoryPlannerHistory;
        $his->inventory_planner_id = $obj->inventory_planner_id;
        $his->approval_type_id = 1;
        $his->inventory_planner_history_text = $request->input('inventory_planner_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'inventoryplannerapproval', 'Please check Inventory Planner "' . $obj->inventory_planner_title . '"', $obj->inventory_planner_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('inventory/inventoryplanner');
    }

    public function show(Request $request, $id)
    {
    	if(Gate::denies('Inventory Planner-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['inventoryplanner'] = InventoryPlanner::with(
                                                        'proposaltype', 
                                                        'inventorycategories', 
        												'inventorysource', 
                                                        'implementations',
        												'sellperiods',
        												'medias',
        												'actionplans',
        												'eventplans',
        												'uploadfiles'
        												)->find($id);

        return view('vendor.material.inventory.inventoryplanner.show', $data);
    }

    public function edit(Request $request, $id)
    {
        if(Gate::denies('Inventory Planner-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['inventory'] = InventoryPlanner::with('proposaltype', 
                                                    'inventorycategories', 
                                                    'inventorysource', 
                                                    'implementations',
                                                    'sellperiods',
                                                    'costdetails',
                                                    'medias',
                                                    'actionplans',
                                                    'eventplans',
                                                    'uploadfiles'
                                                )->find($id);
        $inventory_deadline = Carbon::createFromFormat('Y-m-d', ($data['inventory']->inventory_deadline==null) ? date('Y-m-d') : $data['inventory']->inventory_deadline);
        $data['inventory_deadline'] = $inventory_deadline->format('d/m/Y');

        $data['proposal_types'] = ProposalType::where('active', '1')->orderBy('proposal_type_name')->get();
        $data['inventory_categories'] = InventoryCategory::where('active', '1')->orderBy('inventory_category_name')->get();
        $data['inventory_sources'] = InventorySource::where('active', '1')->orderBy('inventory_source_name')->get();
        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();
        $data['sell_periods'] = SellPeriod::where('active', '1')->orderBy('sell_period_month')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                                    $query->where('users_medias.user_id', '=', $request->user()->user_id);
                                })->where('medias.active', '1')->orderBy('media_name')->get();
        //$data['cost_details'] = InventoryPlannerCostDetails::->orderBy('inventory_planner_cost')->get();
        $data['advertise_sizes'] = AdvertiseSize::where('active', '1')->orderBy('advertise_size_name')->get();
        $data['advertise_positions'] = AdvertisePosition::where('active', '1')->orderBy('advertise_position_name')->get();
        $data['papers'] = Paper::where('active', '1')->orderBy('paper_name')->get();
        $data['price_types'] = PriceType::where('active', '1')->orderBy('price_type_name')->get();

        return view('vendor.material.inventory.inventoryplanner.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'proposal_type_id' => 'required',
            'inventory_category_id[]' => 'array',
            'inventory_source_id' => 'required',
            'inventory_planner_title' => 'required|max:100',
            'inventory_planner_desc' => 'required',
            //'inventory_planner_cost' => 'required|numeric',
            //'inventory_planner_media_cost_print' => 'required|numeric',
            //'inventory_planner_media_cost_other' => 'required|numeric',
            //'inventory_planner_total_offering' => 'required|numeric',
            'offering_cost_details_id[]' => 'array',
            'offering_post_cost[]' => 'array',
            'offering_post_media_cost_print[]' => 'array',
            'offering_post_media_cost_other[]' => 'array',
            'offering_post_total_offering[]' => 'array',
            'implementation_post_id[]' => 'array',
            'implementation_post_year[]' => 'array',
            'sell_period_post_id[]' => 'array',
            'sell_period_post_year[]' => 'array',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = InventoryPlanner::find($id);
        $obj->inventory_source_id = $request->input('inventory_source_id');
        $obj->inventory_planner_title = $request->input('inventory_planner_title');
        $obj->inventory_planner_desc = $request->input('inventory_planner_desc');
        $obj->inventory_planner_cost = 0;
        $obj->inventory_planner_media_cost_print = 0;
        $obj->inventory_planner_media_cost_other = 0;
        $obj->inventory_planner_total_offering = 0;
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->updated_by = $request->user()->user_id;

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
                $upl->upload_file_revision = $obj->revision_no;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $obj->revision_no ];
            }
        }

        if(!empty($fileArray)) {
            InventoryPlanner::find($obj->inventory_planner_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        if(!empty($request->input('inventory_category_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->inventorycategories()->sync($request->input('inventory_category_id'));
        }

        if(!empty($request->input('implementation_post_id'))) {
            $implementation_sync = array();
            $implementation_post_id = $request->input('implementation_post_id');
            $implementation_post_year = $request->input('implementation_post_year');
            foreach($implementation_post_id as $key => $value)
            {
                array_push($implementation_sync, $value);
                $implementation_sync[$value] = [ 'year' => $implementation_post_year[$key] ];
            }

            InventoryPlanner::find($obj->inventory_planner_id)->implementations()->sync($implementation_sync);
        }

        if(!empty($request->input('sell_period_post_id'))) {
            $sell_period_sync = array();
            $sell_period_post_id = $request->input('sell_period_post_id');
            $sell_period_post_year = $request->input('sell_period_post_year');
            foreach($sell_period_post_id as $key => $value)
            {
                array_push($sell_period_sync, $value);
                $sell_period_sync[$value] = [ 'year' => $sell_period_post_year[$key] ];
            }

            InventoryPlanner::find($obj->inventory_planner_id)->sellperiods()->sync($sell_period_sync);
        }

        if(!empty($request->input('media_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->medias()->sync($request->input('media_id'));
        }


        if(!empty($request->input('offering_cost_details_id'))){
            InventoryPlanner::find($obj->inventory_planner_id)->costdetails_auto()->sync($request->input('offering_cost_details_id'));
        }
        
        /*

        $ids = explode(",", $id);
        // call delete on the query builder (no get())
        InventoryPlannerCostDetails::whereIn('inventory_planner_id', $ids)->delete();   
        */
       
        
        //Cost Details
        $data = $request->except('_token');
        $costCount = count($data['offering_post_cost']);
        for($i=0; $i < $costCount; $i++)
        {
            $dat = InventoryPlannerCostDetails::where('inventory_planner_id', $obj->inventory_planner_id)
                            ->where('inventory_planner_cost', $data['offering_post_cost'][$i])
                            ->where('inventory_planner_media_cost_print', $data['offering_post_media_cost_print'][$i])
                            ->where('inventory_planner_media_cost_other', $data['offering_post_media_cost_other'][$i])
                            ->where('inventory_planner_total_offering', $data['offering_post_total_offering'][$i])
                            ->first();
            if($dat === null){
                $costDetails = new InventoryPlannerCostDetails;
                $costDetails->inventory_planner_id = $obj->inventory_planner_id;
                $costDetails->inventory_planner_cost = $data['offering_post_cost'][$i];
                $costDetails->inventory_planner_media_cost_print = $data['offering_post_media_cost_print'][$i];
                $costDetails->inventory_planner_media_cost_other = $data['offering_post_media_cost_other'][$i];
                $costDetails->inventory_planner_total_offering = $data['offering_post_total_offering'][$i];
                $costDetails->revision_no = 0;
                $costDetails->save();
            } 
        }

        
        $his = new InventoryPlannerHistory;
        $his->inventory_planner_id = $obj->inventory_planner_id;
        $his->approval_type_id = 1;
        //$his->inventory_planner_history_text = $request->input('inventory_planner_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();
        
        $this->notif->remove($request->user()->user_id, 'inventoryplannerreject', $obj->inventory_planner_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'inventoryplannerapproval', 'Please check Inventory Planner "' . $obj->inventory_planner_title . '"', $obj->inventory_planner_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('inventory/inventoryplanner');
    }

    public function approve(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            return $this->approveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            return $this->approveFlowNo2($request, $id);
        }
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            $this->postApproveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            $this->postApproveFlowNo2($request, $id);
        }

        return redirect('inventory/inventoryplanner');
    }

    private function approveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Inventory Planner-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['inventoryplanner'] = InventoryPlanner::with(
                                                        'proposaltype', 
                                                        'inventorycategories', 
                                                        'inventorysource', 
                                                        'implementations',
                                                        'sellperiods',
                                                        'costdetails',
                                                        'medias',
                                                        'actionplans',
                                                        'eventplans',
                                                        'uploadfiles'
        												)->find($id);

        return view('vendor.material.inventory.inventoryplanner.approve', $data);
    }

    private function postApproveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Inventory Planner-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required',
            //'costchoose' => 'required',
            //'mediacostprintchoose' => 'required',
            //'mediacostotherchoose' => 'required',
            //'totalofferingchoose' => 'required'
            //'status_cost' => 'required'
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $inventoryplanner = InventoryPlanner::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $inventoryplanner->flow_no, $request->user()->user_id, '', $inventoryplanner->created_by->user_id);

            $inventoryplanner->flow_no = $nextFlow['flow_no'];
            $inventoryplanner->current_user = $nextFlow['current_user'];
            $inventoryplanner->updated_by = $request->user()->user_id;
            $inventoryplanner->save();

            $his = new InventoryPlannerHistory;
            $his->inventory_planner_id = $id;
            $his->approval_type_id = 2;
            $his->inventory_planner_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            /*
            //Update Status
            $det = InventoryPlannerCostDetails::where('inventory_planner_id', $inventoryplanner->inventory_planner_id)
                            ->where('inventory_planner_cost', $request->costchoose)
                            ->where('inventory_planner_media_cost_print', $request->mediacostprintchoose)
                            ->where('inventory_planner_media_cost_other', $request->mediacostotherchoose)
                            ->where('inventory_planner_total_offering', $request->totalofferingchoose)
                            ->first();
            if($det === null){
                $dealCostManual = new InventoryPlannerCostDetails;
                $dealCostManual->inventory_planner_id = $inventoryplanner->inventory_planner_id;
                $dealCostManual->inventory_planner_cost = $request->input('costchoose');
                $dealCostManual->inventory_planner_media_cost_print = $request->input('mediacostprintchoose');
                $dealCostManual->inventory_planner_media_cost_other = $request->input('mediacostotherchoose');
                $dealCostManual->inventory_planner_total_offering = $request->input('totalofferingchoose');
                $dealCostManual->status = 1;
                $dealCostManual->revision_no = 0;
                $dealCostManual->save();
            } else {
                $det->status = 1;
                $det->save();
            }
            */

            $this->notif->remove($request->user()->user_id, 'inventoryplannerapproval', $inventoryplanner->inventory_planner_id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'inventoryplannerfinished', 'Inventory Planner "' . $inventoryplanner->inventory_planner_title . '" has been approved.', $id);

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject

            $inventoryplanner = InventoryPlanner::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $inventoryplanner->flow_no, $request->user()->user_id, '', $inventoryplanner->created_by->user_id);

            $inventoryplanner->flow_no = $prevFlow['flow_no'];
            $inventoryplanner->revision_no = $inventoryplanner->revision_no + 1;
            $inventoryplanner->current_user = $prevFlow['current_user'];
            $inventoryplanner->updated_by = $request->user()->user_id;
            $inventoryplanner->save();
            
            $his = new InventoryPlannerHistory;
            $his->inventory_planner_id = $id;
            $his->approval_type_id = 3;
            $his->inventory_planner_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;
            $his->save();
            
            $obj = InventoryPlanner::find($id);
            $obj->inventory_source_id = $request->input('inventory_source_id');
            $obj->inventory_planner_title = $request->input('inventory_planner_title');
            $obj->inventory_planner_desc = $request->input('inventory_planner_desc');
            

            $this->notif->remove($request->user()->user_id, 'inventoryplannerapproval', $inventoryplanner->inventory_planner_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'inventoryplannerreject', 'Inventory Planner "' . $inventoryplanner->inventory_planner_title . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

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
            $data['rows'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.current_user')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.active', '=', '1')
                                ->where('inventories_planner.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.current_user')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.active', '=', '1')
                                ->where('inventories_planner.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.flow_no','<>','99')
                                ->where('inventories_planner.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','<>','98')
                                ->where('inventories_planner.flow_no','<>','99')
                                ->where('inventories_planner.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'users.user_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','=','98')
                                /*->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })*/
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'users.user_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','1')
                                ->where('inventories_planner.flow_no','=','98')
                                /*->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })*/
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','0')
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = InventoryPlanner::select('media_name', 'inventory_category_name', 'implementation_month_name', 'inventory_planner_implementation.year', 'inventory_planner_title', 'user_firstname', 'inventories_planner.updated_at', 'inventories_planner.inventory_planner_id', 'flow_no')
                                ->join('inventory_planner_media', 'inventory_planner_media.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('medias', 'medias.media_id', '=', 'inventory_planner_media.media_id')
                                ->join('inventory_category_inventory_planner', 'inventory_category_inventory_planner.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('inventory_categories', 'inventory_categories.inventory_category_id', '=', 'inventory_category_inventory_planner.inventory_category_id')
                                ->join('inventory_planner_implementation', 'inventory_planner_implementation.inventory_planner_id', '=', 'inventories_planner.inventory_planner_id')
                                ->join('implementations', 'implementations.implementation_id', '=', 'inventory_planner_implementation.implementation_id')
                                ->join('users','users.user_id', '=', 'inventories_planner.created_by')
                                ->where('inventories_planner.active','0')
                                ->where(function($query) use($request){
                                    if($request->input('medias')!=''){
                                        $query->whereIn('medias.media_id',  $request->input('medias'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('categories')!=''){
                                        $query->whereIn('inventory_categories.inventory_category_id',  $request->input('categories'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('implementations')!=''){
                                        $query->whereIn('inventory_planner_implementation.implementation_id',  $request->input('implementations'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('years')!=''){
                                        $query->whereIn('inventory_planner_implementation.year',  $request->input('years'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('inventories_planner.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('inventories_planner.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('media_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_category_name', 'like', '%' . $searchPhrase . '%')
                                            ->orWhere('implementation_month_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('year','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventory_planner_title','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                            ->orWhere('inventories_planner.updated_at','like','%' . $searchPhrase . '%');
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

    	$advertise_rate_id = $request->input('advertise_rate_id');
    	if($advertise_rate_id != 0) {
    		$rate = AdvertiseRate::find($advertise_rate_id);

    		$data['basic_rate'] = $rate->advertise_rate_normal;	
    	}else{
    		$data['basic_rate'] = 0;
    	}
    	

    	return $data;
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Inventory Planner-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('inventory_planner_id');

        $obj = InventoryPlanner::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
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

    public function calculateAllPrices($id) {
    	$data = array();

    	$grossprint = InventoryPlannerPrintPrice::where('inventory_planner_id', $id)->sum('inventory_planner_print_price_total_gross_rate');
    	$grossdigital = InventoryPlannerDigitalPrice::where('inventory_planner_id', $id)->sum('inventory_planner_digital_price_total_gross_rate');
    	$grossevent = InventoryPlannerEventPrice::where('inventory_planner_id', $id)->sum('inventory_planner_event_price_total_gross_rate');
    	$grosscreative = InventoryPlannerCreativePrice::where('inventory_planner_id', $id)->sum('inventory_planner_creative_price_total_gross_rate');
    	$grossother = InventoryPlannerOtherPrice::where('inventory_planner_id', $id)->sum('inventory_planner_other_price_total_gross_rate');

    	$nettprint = InventoryPlannerPrintPrice::where('inventory_planner_id', $id)->sum('inventory_planner_print_price_total_gross_rate');
    	$nettdigital = InventoryPlannerDigitalPrice::where('inventory_planner_id', $id)->sum('inventory_planner_digital_price_total_gross_rate');
    	$nettevent = InventoryPlannerEventPrice::where('inventory_planner_id', $id)->sum('inventory_planner_event_price_total_gross_rate');
    	$nettcreative = InventoryPlannerCreativePrice::where('inventory_planner_id', $id)->sum('inventory_planner_creative_price_total_gross_rate');
    	$nettother = InventoryPlannerOtherPrice::where('inventory_planner_id', $id)->sum('inventory_planner_other_price_total_gross_rate');
    }

    public function apiSearch(Request $request)
    {
        if(Gate::denies('Home-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $inventory_planner_title = $request->inventory_planner_title;

        $result = InventoryPlanner::where('inventory_planner_title','like','%' . $inventory_planner_title . '%')->where('active', '1')->take(5)->orderBy('inventory_planner_title')->get();

        return response()->json($result, 200);
    }

    public function renew(Request $request, $id)
    {
        if(Gate::denies('Inventory Planner-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['inventory'] = InventoryPlanner::with('proposaltype', 
                                                    'inventorycategories', 
                                                    'inventorysource', 
                                                    'implementations',
                                                    'sellperiods',
                                                    'medias',
                                                    'actionplans',
                                                    'eventplans',
                                                    'uploadfiles'
                                                )->find($id);
        $inventory_deadline = Carbon::createFromFormat('Y-m-d', ($data['inventory']->inventory_deadline==null) ? date('Y-m-d') : $data['inventory']->inventory_deadline);
        $data['inventory_deadline'] = $inventory_deadline->format('d/m/Y');

        $data['proposal_types'] = ProposalType::where('active', '1')->orderBy('proposal_type_name')->get();
        $data['inventory_categories'] = InventoryCategory::where('active', '1')->orderBy('inventory_category_name')->get();
        $data['inventory_sources'] = InventorySource::where('active', '1')->orderBy('inventory_source_name')->get();
        $data['implementations'] = Implementation::where('active', '1')->orderBy('implementation_month')->get();
        $data['sell_periods'] = SellPeriod::where('active', '1')->orderBy('sell_period_month')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                                    $query->where('users_medias.user_id', '=', $request->user()->user_id);
                                })->where('medias.active', '1')->orderBy('media_name')->get();

        return view('vendor.material.inventory.inventoryplanner.renew', $data);
    }

    public function postRenew(Request $request, $id)
    {
        $this->validate($request, [
            'proposal_type_id' => 'required',
            'inventory_category_id[]' => 'array',
            'inventory_source_id' => 'required',
            'inventory_planner_title' => 'required|max:100',
            'inventory_planner_desc' => 'required',
            //'inventory_planner_cost' => 'required|numeric',
            //'inventory_planner_media_cost_print' => 'required|numeric',
            //'inventory_planner_media_cost_other' => 'required|numeric',
            //'inventory_planner_total_offering' => 'required|numeric',
            'offering_post_cost[]' => 'array',
            'offering_post_media_cost_print[]' => 'array',
            'offering_post_media_cost_other[]' => 'array',
            'offering_post_total_offering[]' => 'array',
            'implementation_post_id[]' => 'array',
            'implementation_post_year[]' => 'array',
            'sell_period_post_id[]' => 'array',
            'sell_period_post_year[]' => 'array',
            'media_id[]' => 'array',
        ]);


        $obj = InventoryPlanner::find($id);
        $obj->inventory_source_id = $request->input('inventory_source_id');
        $obj->inventory_planner_title = $request->input('inventory_planner_title');
        $obj->inventory_planner_desc = $request->input('inventory_planner_desc');
        $obj->inventory_planner_cost = 0; //$request->input('inventory_planner_cost');
        $obj->inventory_planner_media_cost_print = 0; // $request->input('inventory_planner_media_cost_print');
        $obj->inventory_planner_media_cost_other = 0; // $request->input('inventory_planner_media_cost_other');
        $obj->inventory_planner_total_offering = 0; // $request->input('inventory_planner_total_offering');
        $obj->revision_no = $obj->revision_no + 1;
        $obj->updated_by = $request->user()->user_id;

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
                $upl->upload_file_revision = $obj->revision_no;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $obj->revision_no ];
            }
        }

        if(!empty($fileArray)) {
            InventoryPlanner::find($obj->inventory_planner_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        if(!empty($request->input('inventory_category_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->inventorycategories()->sync($request->input('inventory_category_id'));
        }

        if(!empty($request->input('implementation_post_id'))) {
            $implementation_sync = array();
            $implementation_post_id = $request->input('implementation_post_id');
            $implementation_post_year = $request->input('implementation_post_year');
            foreach($implementation_post_id as $key => $value)
            {
                array_push($implementation_sync, $value);
                $implementation_sync[$value] = [ 'year' => $implementation_post_year[$key] ];
            }

            InventoryPlanner::find($obj->inventory_planner_id)->implementations()->sync($implementation_sync);
        }

        if(!empty($request->input('sell_period_post_id'))) {
            $sell_period_sync = array();
            $sell_period_post_id = $request->input('sell_period_post_id');
            $sell_period_post_year = $request->input('sell_period_post_year');
            foreach($sell_period_post_id as $key => $value)
            {
                array_push($sell_period_sync, $value);
                $sell_period_sync[$value] = [ 'year' => $sell_period_post_year[$key] ];
            }

            InventoryPlanner::find($obj->inventory_planner_id)->sellperiods()->sync($sell_period_sync);
        }

        if(!empty($request->input('media_id'))) {
            InventoryPlanner::find($obj->inventory_planner_id)->medias()->sync($request->input('media_id'));
        }

        if(!empty($request->input('offering_cost_details_id'))){
            InventoryPlanner::find($obj->inventory_planner_id)->costdetails_auto()->sync($request->input('offering_cost_details_id'));
        }
        
        /*

        $ids = explode(",", $id);
        // call delete on the query builder (no get())
        InventoryPlannerCostDetails::whereIn('inventory_planner_id', $ids)->delete();   
        */
       
        
        //Cost Details
        $data = $request->except('_token');
        $costCount = count($data['offering_post_cost']);
        for($i=0; $i < $costCount; $i++)
        {
            $dat = InventoryPlannerCostDetails::where('inventory_planner_id', $obj->inventory_planner_id)
                            ->where('inventory_planner_cost', $data['offering_post_cost'][$i])
                            ->where('inventory_planner_media_cost_print', $data['offering_post_media_cost_print'][$i])
                            ->where('inventory_planner_media_cost_other', $data['offering_post_media_cost_other'][$i])
                            ->where('inventory_planner_total_offering', $data['offering_post_total_offering'][$i])
                            ->first();
            if($dat === null){
                $costDetails = new InventoryPlannerCostDetails;
                $costDetails->inventory_planner_id = $obj->inventory_planner_id;
                $costDetails->inventory_planner_cost = $data['offering_post_cost'][$i];
                $costDetails->inventory_planner_media_cost_print = $data['offering_post_media_cost_print'][$i];
                $costDetails->inventory_planner_media_cost_other = $data['offering_post_media_cost_other'][$i];
                $costDetails->inventory_planner_total_offering = $data['offering_post_total_offering'][$i];
                $costDetails->revision_no = 0;
                $costDetails->save();
            } 
        }

        $his = new InventoryPlannerHistory;
        $his->inventory_planner_id = $obj->inventory_planner_id;
        $his->approval_type_id = 1;
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('inventory/inventoryplanner');
    }

    public function apiLoadLastUpdated(Request $request, $limit)
    {
        $userdata = User::with('medias')->find($request->user()->user_id);

        $medias = [];
        foreach ($userdata->medias as $value) {
            array_push($medias, $value->media_id);
        }

        $inventoryplanner = InventoryPlanner::with('implementations')
                                ->where('flow_no', 98)
                                ->where('active', '1')
                                ->whereHas('medias', function($query) use($medias){
                                    $query->whereIn('medias.media_id', $medias);
                                })
                                ->orderBy('updated_at', 'desc')
                                ->limit($limit)->get();

        return response()->json($inventoryplanner);
    }
}
