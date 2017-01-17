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
use App\Brand;
use App\Client;
use App\ClientContact;
use App\Industry;
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

    public function create(Request $request)
    {
        if(Gate::denies('Proposal-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal_types'] = ProposalType::select('proposal_type_id','proposal_type_name', 'proposal_type_duration')->where('active', '1')->orderBy('proposal_type_name')->get();
        $data['industries'] = Industry::select('industry_id','industry_name')->where('active', '1')->orderBy('industry_name')->get();
        $data['medias'] = Media::select('media_id','media_name')->whereHas('users', function($query) use($request){
                                    $query->where('users_medias.user_id', '=', $request->user()->user_id);
                                })->where('medias.active', '1')->orderBy('media_name')->get();

        $data['advertise_sizes'] = AdvertiseSize::select('advertise_size_id','advertise_size_name')->where('active', '1')->orderBy('advertise_size_name')->get();
        $data['advertise_positions'] = AdvertisePosition::select('advertise_position_id','advertise_position_name')->where('active', '1')->orderBy('advertise_position_name')->get();
        $data['papers'] = Paper::select('paper_id','paper_name')->where('active', '1')->orderBy('paper_name')->get();
        $data['price_types'] = PriceType::select('price_type_id','price_type_name')->where('active', '1')->orderBy('price_type_name')->get();

        return view('vendor.material.workorder.proposal.create', $data);   
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

    public function apiGenerateDeadline(Request $request)
    {
        $proposal_type_id = $request->proposal_type_id;

        $proposaltype = ProposalType::select('proposal_type_id','proposal_type_name', 'proposal_type_duration')->find($proposal_type_id);

        $deadline = Carbon::now()->addDays($proposaltype->proposal_type_duration);

        echo $deadline;
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
        if(Gate::denies('Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['prices'] = $request->session()->get('proposal_print_prices_' . $request->user()->user_id);

        return response()->json($data);
    }

    public function apiStorePrintPrices(Request $request) {
        if(Gate::denies('Proposal-Create')) {
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
        $proposal_print_price_gross_rate = $request->input('proposal_print_price_gross_rate');
        $proposal_print_price_surcharge = $request->input('proposal_print_price_surcharge');
        $proposal_print_price_total_gross_rate = $request->input('proposal_print_price_total_gross_rate');
        $proposal_print_price_discount = $request->input('proposal_print_price_discount');
        $proposal_print_price_nett_rate = $request->input('proposal_print_price_nett_rate');
        $proposal_print_price_remarks = $request->input('proposal_print_price_remarks');

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
        $price['proposal_print_price_gross_rate'] = $proposal_print_price_gross_rate;
        $price['proposal_print_price_surcharge'] = $proposal_print_price_surcharge;
        $price['proposal_print_price_total_gross_rate'] = $proposal_print_price_total_gross_rate;
        $price['proposal_print_price_discount'] = $proposal_print_price_discount;
        $price['proposal_print_price_nett_rate'] = $proposal_print_price_nett_rate;
        $price['proposal_print_price_remarks'] = $proposal_print_price_remarks;

        $prices = array();
        if($request->session()->has('proposal_print_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_print_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_print_prices_' . $request->user()->user_id);
            $i = count($prices) + 1;
        }else{
            $i = 1;
        }

        $prices[] = $price;

        $request->session()->put('proposal_print_prices_' . $request->user()->user_id, $prices);
        
        $data['status'] = '200';

        return response()->json($data);
    }

    public function apiDeletePrintPrices(Request $request) {
        $data = array();

        $key = $request->input('key');

        $prices = array();
        if($request->session()->has('proposal_print_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_print_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_print_prices_' . $request->user()->user_id);

            unset($prices[$key]);

            $request->session()->put('proposal_print_prices_' . $request->user()->user_id, $prices);
        
            $data['status'] = '200';

            return response()->json($data); 
        }else{
            $data['status'] = '500';

            return response()->json($data);
        }


    }

    public function apiLoadDigitalPrices(Request $request) {
        if(Gate::denies('Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['prices'] = $request->session()->get('proposal_digital_prices_' . $request->user()->user_id);

        return response()->json($data);
    }

    public function apiStoreDigitalPrices(Request $request) {
        if(Gate::denies('Proposal-Create')) {
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
        $proposal_digital_price_startdate = $request->input('proposal_digital_price_startdate');
        $proposal_digital_price_enddate = $request->input('proposal_digital_price_enddate');
        $proposal_digital_price_deadline = $request->input('proposal_digital_price_deadline');
        $proposal_digital_price_gross_rate = $request->input('proposal_digital_price_gross_rate');
        $proposal_digital_price_surcharge = $request->input('proposal_digital_price_surcharge');
        $proposal_digital_price_total_gross_rate = $request->input('proposal_digital_price_total_gross_rate');
        $proposal_digital_price_discount = $request->input('proposal_digital_price_discount');
        $proposal_digital_price_nett_rate = $request->input('proposal_digital_price_nett_rate');
        $proposal_digital_price_remarks = $request->input('proposal_digital_price_remarks');

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
        $price['proposal_digital_price_startdate'] = $proposal_digital_price_startdate;
        $price['proposal_digital_price_enddate'] = $proposal_digital_price_enddate;
        $price['proposal_digital_price_deadline'] = $proposal_digital_price_deadline;
        $price['proposal_digital_price_gross_rate'] = $proposal_digital_price_gross_rate;
        $price['proposal_digital_price_surcharge'] = $proposal_digital_price_surcharge;
        $price['proposal_digital_price_total_gross_rate'] = $proposal_digital_price_total_gross_rate;
        $price['proposal_digital_price_discount'] = $proposal_digital_price_discount;
        $price['proposal_digital_price_nett_rate'] = $proposal_digital_price_nett_rate;
        $price['proposal_digital_price_remarks'] = $proposal_digital_price_remarks;

        $prices = array();
        if($request->session()->has('proposal_digital_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_digital_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_digital_prices_' . $request->user()->user_id);
            $i = count($prices) + 1;
        }else{
            $i = 1;
        }

        $prices[] = $price;

        $request->session()->put('proposal_digital_prices_' . $request->user()->user_id, $prices);
        
        $data['status'] = '200';

        return response()->json($data);
    }

    public function apiDeleteDigitalPrices(Request $request) {
        $data = array();

        $key = $request->input('key');

        $prices = array();
        if($request->session()->has('proposal_digital_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_digital_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_digital_prices_' . $request->user()->user_id);

            unset($prices[$key]);

            $request->session()->put('proposal_digital_prices_' . $request->user()->user_id, $prices);
        
            $data['status'] = '200';

            return response()->json($data); 
        }else{
            $data['status'] = '500';

            return response()->json($data);
        }


    }


    public function apiLoadEventPrices(Request $request) {
        if(Gate::denies('Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['prices'] = $request->session()->get('proposal_event_prices_' . $request->user()->user_id);

        return response()->json($data);
    }

    public function apiStoreEventPrices(Request $request) {
        if(Gate::denies('Proposal-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $price_type_id = $request->input('price_type_id');
        $media_id = $request->input('media_id');
        $media_name = $request->input('media_name');
        $proposal_event_price_gross_rate = $request->input('proposal_event_price_gross_rate');
        $proposal_event_price_surcharge = $request->input('proposal_event_price_surcharge');
        $proposal_event_price_total_gross_rate = $request->input('proposal_event_price_total_gross_rate');
        $proposal_event_price_discount = $request->input('proposal_event_price_discount');
        $proposal_event_price_nett_rate = $request->input('proposal_event_price_nett_rate');
        $proposal_event_price_remarks = $request->input('proposal_event_price_remarks');

        $price = array();
        $price['price_type_id'] = $price_type_id;
        $price['media_id'] = $media_id;
        $price['media_name'] = $media_name;
        $price['proposal_event_price_gross_rate'] = $proposal_event_price_gross_rate;
        $price['proposal_event_price_surcharge'] = $proposal_event_price_surcharge;
        $price['proposal_event_price_total_gross_rate'] = $proposal_event_price_total_gross_rate;
        $price['proposal_event_price_discount'] = $proposal_event_price_discount;
        $price['proposal_event_price_nett_rate'] = $proposal_event_price_nett_rate;
        $price['proposal_event_price_remarks'] = $proposal_event_price_remarks;

        $prices = array();
        if($request->session()->has('proposal_event_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_event_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_event_prices_' . $request->user()->user_id);
            $i = count($prices) + 1;
        }else{
            $i = 1;
        }

        $prices[] = $price;

        $request->session()->put('proposal_event_prices_' . $request->user()->user_id, $prices);
        
        $data['status'] = '200';

        return response()->json($data);
    }

    public function apiDeleteEventPrices(Request $request) {
        $data = array();

        $key = $request->input('key');

        $prices = array();
        if($request->session()->has('proposal_event_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_event_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_event_prices_' . $request->user()->user_id);

            unset($prices[$key]);

            $request->session()->put('proposal_event_prices_' . $request->user()->user_id, $prices);
        
            $data['status'] = '200';

            return response()->json($data); 
        }else{
            $data['status'] = '500';

            return response()->json($data);
        }


    }


    public function apiLoadCreativePrices(Request $request) {
        if(Gate::denies('Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['prices'] = $request->session()->get('proposal_creative_prices_' . $request->user()->user_id);

        return response()->json($data);
    }

    public function apiStoreCreativePrices(Request $request) {
        if(Gate::denies('Proposal-Create')) {
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
        $proposal_creative_price_gross_rate = $request->input('proposal_creative_price_gross_rate');
        $proposal_creative_price_surcharge = $request->input('proposal_creative_price_surcharge');
        $proposal_creative_price_total_gross_rate = $request->input('proposal_creative_price_total_gross_rate');
        $proposal_creative_price_discount = $request->input('proposal_creative_price_discount');
        $proposal_creative_price_nett_rate = $request->input('proposal_creative_price_nett_rate');
        $proposal_creative_price_remarks = $request->input('proposal_creative_price_remarks');

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
        $price['proposal_creative_price_gross_rate'] = $proposal_creative_price_gross_rate;
        $price['proposal_creative_price_surcharge'] = $proposal_creative_price_surcharge;
        $price['proposal_creative_price_total_gross_rate'] = $proposal_creative_price_total_gross_rate;
        $price['proposal_creative_price_discount'] = $proposal_creative_price_discount;
        $price['proposal_creative_price_nett_rate'] = $proposal_creative_price_nett_rate;
        $price['proposal_creative_price_remarks'] = $proposal_creative_price_remarks;

        $prices = array();
        if($request->session()->has('proposal_creative_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_creative_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_creative_prices_' . $request->user()->user_id);
            $i = count($prices) + 1;
        }else{
            $i = 1;
        }

        $prices[] = $price;

        $request->session()->put('proposal_creative_prices_' . $request->user()->user_id, $prices);
        
        $data['status'] = '200';

        return response()->json($data);
    }

    public function apiDeleteCreativePrices(Request $request) {
        $data = array();

        $key = $request->input('key');

        $prices = array();
        if($request->session()->has('proposal_creative_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_creative_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_creative_prices_' . $request->user()->user_id);

            unset($prices[$key]);

            $request->session()->put('proposal_creative_prices_' . $request->user()->user_id, $prices);
        
            $data['status'] = '200';

            return response()->json($data); 
        }else{
            $data['status'] = '500';

            return response()->json($data);
        }


    }

    public function apiLoadOtherPrices(Request $request) {
        if(Gate::denies('Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['prices'] = $request->session()->get('proposal_other_prices_' . $request->user()->user_id);

        return response()->json($data);
    }

    public function apiStoreOtherPrices(Request $request) {
        if(Gate::denies('Proposal-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $price_type_id = $request->input('price_type_id');
        $media_id = $request->input('media_id');
        $media_name = $request->input('media_name');
        $proposal_other_price_gross_rate = $request->input('proposal_other_price_gross_rate');
        $proposal_other_price_surcharge = $request->input('proposal_other_price_surcharge');
        $proposal_other_price_total_gross_rate = $request->input('proposal_other_price_total_gross_rate');
        $proposal_other_price_discount = $request->input('proposal_other_price_discount');
        $proposal_other_price_nett_rate = $request->input('proposal_other_price_nett_rate');
        $proposal_other_price_remarks = $request->input('proposal_other_price_remarks');

        $price = array();
        $price['price_type_id'] = $price_type_id;
        $price['media_id'] = $media_id;
        $price['media_name'] = $media_name;
        $price['proposal_other_price_gross_rate'] = $proposal_other_price_gross_rate;
        $price['proposal_other_price_surcharge'] = $proposal_other_price_surcharge;
        $price['proposal_other_price_total_gross_rate'] = $proposal_other_price_total_gross_rate;
        $price['proposal_other_price_discount'] = $proposal_other_price_discount;
        $price['proposal_other_price_nett_rate'] = $proposal_other_price_nett_rate;
        $price['proposal_other_price_remarks'] = $proposal_other_price_remarks;

        $prices = array();
        if($request->session()->has('proposal_other_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_other_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_other_prices_' . $request->user()->user_id);
            $i = count($prices) + 1;
        }else{
            $i = 1;
        }

        $prices[] = $price;

        $request->session()->put('proposal_other_prices_' . $request->user()->user_id, $prices);
        
        $data['status'] = '200';

        return response()->json($data);
    }

    public function apiDeleteOtherPrices(Request $request) {
        $data = array();

        $key = $request->input('key');

        $prices = array();
        if($request->session()->has('proposal_other_prices_' . $request->user()->user_id)) {
            $prices = $request->session()->get('proposal_other_prices_' . $request->user()->user_id);
            $request->session()->forget('proposal_other_prices_' . $request->user()->user_id);

            unset($prices[$key]);

            $request->session()->put('proposal_other_prices_' . $request->user()->user_id, $prices);
        
            $data['status'] = '200';

            return response()->json($data); 
        }else{
            $data['status'] = '500';

            return response()->json($data);
        }


    }

    public function calculateAllPrices($id) {
        $data = array();

        $grossprint = ProposalPrintPrice::where('proposal_id', $id)->sum('proposal_print_price_total_gross_rate');
        $grossdigital = ProposalDigitalPrice::where('proposal_id', $id)->sum('proposal_digital_price_total_gross_rate');
        $grossevent = ProposalEventPrice::where('proposal_id', $id)->sum('proposal_event_price_total_gross_rate');
        $grosscreative = ProposalCreativePrice::where('proposal_id', $id)->sum('proposal_creative_price_total_gross_rate');
        $grossother = ProposalOtherPrice::where('proposal_id', $id)->sum('proposal_other_price_total_gross_rate');

        $nettprint = ProposalPrintPrice::where('proposal_id', $id)->sum('proposal_print_price_total_gross_rate');
        $nettdigital = ProposalDigitalPrice::where('proposal_id', $id)->sum('proposal_digital_price_total_gross_rate');
        $nettevent = ProposalEventPrice::where('proposal_id', $id)->sum('proposal_event_price_total_gross_rate');
        $nettcreative = ProposalCreativePrice::where('proposal_id', $id)->sum('proposal_creative_price_total_gross_rate');
        $nettother = ProposalOtherPrice::where('proposal_id', $id)->sum('proposal_other_price_total_gross_rate');
    }
}
