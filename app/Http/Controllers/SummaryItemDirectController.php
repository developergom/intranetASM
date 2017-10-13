<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Client;
use App\ClientContact;
use App\Flow;
use App\Industry;
use App\Media;
use App\OmzetType;
use App\PO;
use App\Proposal;
use App\ProposalHistory;
use App\Rate;
use App\Summary;
use App\SummaryItem;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\GeneratorLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class SummaryItemDirectController extends Controller
{
    private $notif;
    private $summary_item_types = [];
    private $summary_item_viewed = [];

    public function __construct() {
        $this->notif = new NotificationLibrary;
        $this->summary_item_types = ['cost_pro', 'media_cost'];
        $this->summary_item_viewed = ['PROCESS', 'CONFIRMED', 'TBC', 'COMPLETED'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Direct Order-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.posisiiklan.directorder.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Direct Order-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['industry'] = Industry::where('active','1')->orderBy('industry_name')->get();
        $data['omzettypes'] = OmzetType::where('active', '1')->orderBy('omzet_type_name')->get();
        $data['summary_item_types'] = $this->summary_item_types;
        $data['summary_item_viewed'] = $this->summary_item_viewed;
        
        return view('vendor.material.posisiiklan.directorder.create', $data);
    }

    public function apiList(Request $request)
    {
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
        $data['rows'] = SummaryItem::select('summary_item_id', 'summary_item_title', 'clients.client_name', 'rates.rate_name', 'summary_item_period_start', 'summary_items.updated_at', 'users.user_firstname')
        					->join('clients','clients.client_id', '=', 'summary_items.client_id')
                            ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                            ->join('users', 'users.user_id', '=', 'summary_items.sales_id')
                            ->where('summary_items.active','1')
                            ->where('summary_items.source_type','DIRECT')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('summary_item_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = SummaryItem::select('summary_item_id', 'summary_item_title', 'clients.client_name', 'rates.rate_name', 'summary_item_period_start', 'summary_items.updated_at', 'users.user_firstname')
        					->join('clients','clients.client_id', '=', 'summary_items.client_id')
                            ->join('rates','rates.rate_id', '=', 'summary_items.rate_id')
                            ->join('users', 'users.user_id', '=', 'summary_items.sales_id')
                            ->where('summary_items.active','1')
                            ->where('summary_items.source_type','DIRECT')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('summary_item_title','like','%' . $searchPhrase . '%')
                                        ->orWhere('client_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('user_firstname','like','%' . $searchPhrase . '%')
                                        ->orWhere('summary_item_period_start','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }
}
