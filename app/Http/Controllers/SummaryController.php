<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Excel;
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
use App\Rate;
use App\Summary;
use App\SummaryHistory;
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

        //$this->exportToExcel(13);

        return view('vendor.material.workorder.summary.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($proposal_id)
    {
        if(Gate::denies('Summary-Create')) {
            abort(403, 'Unauthorized action.');
        }

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

        $notes = '';

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
        //dd($request->all(), false);
        //dd($request->session()->get('summary_details_' . $request->user()->user_id));

        $this->validate($request,
            [
                'proposal_id' => 'required|numeric',
                'summary_total_gross' => 'required|numeric',
                'summary_total_discount' => 'required|numeric',
                'summary_total_nett' => 'required|numeric',
                'summary_total_internal_omzet' => 'required|numeric',
                'summary_total_media_cost' => 'required|numeric',
                'summary_total_cost_pro' => 'required|numeric',
                'top_type' => 'required',
                'summary_notes' => 'required',
                'messages' => 'required'
            ]
        );

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new Summary;
        $obj->proposal_id = $request->input('proposal_id');
        $obj->summary_order_no = '';
        $obj->summary_sent_date = '';
        $obj->summary_total_gross = $request->input('summary_total_gross');
        $obj->summary_total_disc = $request->input('summary_total_discount');
        $obj->summary_total_nett = $request->input('summary_total_nett');
        $obj->summary_total_internal_omzet = $request->input('summary_total_internal_omzet');
        $obj->summary_total_media_cost = $request->input('summary_total_media_cost');
        $obj->summary_total_cost_pro = $request->input('summary_total_cost_pro');
        $obj->summary_notes = $request->input('summary_notes');
        $obj->top_type = $request->input('top_type');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->revision_no = 0;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $generator = new GeneratorLibrary;
        $summary_order_no = $generator->summary_order_no($obj->summary_id);

        $obj->summary_order_no = $summary_order_no;
        $obj->save();
        //
        

        $hot = $request->session()->get('summary_details_' . $request->user()->user_id);

        for($i = 0;$i < (count($hot)-1);$i++)
        {
            //dd($hot[$i]);

            $rate = Rate::where('rate_name', $hot[$i][2])->where('active', 1)->first();
            $omzettype = OmzetType::where('omzet_type_name', $hot[$i][6])->where('active', 1)->first();

            $detail = new SummaryItem;
            $detail->rate_id = $rate->rate_id;
            $detail->summary_id = $obj->summary_id;
            $detail->summary_item_type = $hot[$i][1];
            $detail->summary_item_period_start = ($hot[$i][4]!='') ? Carbon::createFromFormat('d/m/Y', $hot[$i][4])->toDateString() : '';
            $detail->summary_item_period_end = ($hot[$i][5]!='') ? Carbon::createFromFormat('d/m/Y', $hot[$i][5])->toDateString() : '';
            $detail->omzet_type_id = $omzettype->omzet_type_id;
            $detail->summary_item_insertion = $hot[$i][7];
            $detail->summary_item_gross = $hot[$i][8];
            $detail->summary_item_disc = $hot[$i][9];
            $detail->summary_item_nett = $hot[$i][10];
            $detail->summary_item_internal_omzet = $hot[$i][11];
            $detail->summary_item_remarks = $hot[$i][12];
            $detail->summary_item_termin = $hot[$i][13];
            $detail->summary_item_viewed = $hot[$i][14];
            $detail->revision_no = 0;
            $detail->active = '1';
            $detail->created_by = $request->user()->user_id;

            $detail->save();
        }

        $his = new SummaryHistory;
        $his->summary_id = $obj->summary_id;
        $his->approval_type_id = 1;
        $his->summary_history_text = $request->input('messages');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryapproval', 'Please check Summary', $obj->summary_id);

        $request->session()->forget('summary_details_' . $request->user()->user_id);
        $request->session()->flash('status', 'Data has been saved!');

        return redirect('workorder/summary');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Summary-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $summary = Summary::find($id);

        $data['summary'] = Summary::with(
                    'summaryitems', 
                    'proposal', 
                    'proposal.brand', 
                    'proposal.medias', 
                    'proposal.client', 
                    'proposal.client.clienttype', 
                    'proposal.client_contacts', 
                    'proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                )->whereHas('summaryitems', function($query) use ($summary){
                    $query->where('revision_no', '=', $summary->revision_no);
                })->find($id);

        return view('vendor.material.workorder.summary.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Summary-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $summary = Summary::find($id);

        $data['summary'] = Summary::with(
                    'summaryitems', 
                    'proposal', 
                    'proposal.brand', 
                    'proposal.medias', 
                    'proposal.client', 
                    'proposal.client.clienttype', 
                    'proposal.client_contacts', 
                    'proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                )->whereHas('summaryitems', function($query) use ($summary){
                    $query->where('revision_no', '=', $summary->revision_no);
                })->find($id);

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
                                        )->find($summary->proposal_id);

        return view('vendor.material.workorder.summary.edit', $data);
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
            $data['rows'] = Summary::select('summaries.summary_id', 'proposal_name', 'summary_order_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
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
            $data['total'] = Summary::select('summaries.summary_id', 'proposal_name', 'summary_order_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
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
            $data['rows'] = Summary::select('summaries.summary_id', 'proposal_name', 'summary_order_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
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
            $data['total'] = Summary::select('summaries.summary_id', 'proposal_name', 'summary_order_no' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
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
            $data['rows'] =  Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name' ,'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
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
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
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
            $data['rows'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
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
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
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

    public function apiLoadDetails(Request $request)
    {
        $data = array();
        if($request->session()->has('summary_details_' . $request->user()->user_id)) {
            $data = $request->session()->get('summary_details_' . $request->user()->user_id);
        }

        return response()->json($data);
    }

    private function exportToExcel($summary_id)
    {
        $data = Summary::with('summaryitems', 'proposal', 'proposal.brand', 'proposal.medias', 'proposal', 'proposal.client', 'proposal.client.clienttype', 'proposal.client_contacts', 'proposal.industries', 'summaryitems.rate', 'summaryitems.rate.media', 'summaryitems.omzettype')->find($summary_id);

        //dd($summary);

        Excel::create('Summary - ' . $data->proposal->proposal_name . ' Revision No = ' . $data->revision_no, function($excel) use($data) {

            $excel->sheet('SUMMARY', function($sheet) use($data) {

                $summaryitems = array();
                foreach($data->summaryitems as $key => $value)
                {
                    $item = array(
                                $key+1,
                                $value->summary_item_type,
                                $value->rate->media->media_name,
                                $value->summary_item_period_start . '-' . $value->summary_item_period_end,
                                $value->rate->rate_name,
                                $value->omzettype->omzet_type_name,
                                $value->summary_item_insertion,
                                $value->summary_item_gross,
                                $value->summary_item_disc,
                                $value->summary_item_nett,
                                '',
                                $value->summary_item_internal_omzet,
                                $value->summary_item_remarks
                            );

                    array_push($summaryitems, $item);
                }

                //dd($summaryitems);

                $sheet->fromArray($summaryitems);

                $sheet->prependRow(1, array(
                    ''
                ));

                $sheet->prependRow(2, array(
                    'NAMA PT', '', '', 'SALES AGENT', 'ORDER FO', '', '', 'INDUSTRY/BRAND', '', '', 'PAYER', ': ' . $data->proposal->client->clienttype->client_type_name, ''
                ));

                $industry = '';
                foreach($data->proposal->industries as $row){
                    $industry .= $row->industry_name . ', ';
                }

                $sheet->prependRow(3, array(
                                        'PT ...', '', '',
                                        $data->proposal->created_by->user_firstname . ' ' . $data->proposal->created_by->user_lastname,
                                        'NO ORDER', ': ' . $data->summary_order_no, '',
                                        'INDUSTRY', ': ' . $industry, '',
                                        'BILL TO PARTY', ': ' . $data->proposal->client->client_name, ''
                                    ));

                $media = '';
                foreach($data->proposal->medias as $row){
                    $media .= $row->media_name . ', ';
                }
                $sheet->prependRow(4, array(
                                        '', '', '', '',
                                        'MEDIA', ': ' . $media, '',
                                        'COMPANY', ':', '',
                                        'PIC', '', ''
                                    ));

                $client_contact_name = '';
                $client_contact_position = '';
                $client_contact_phone = '';
                foreach($data->proposal->client_contacts as $row){
                    $client_contact_name .= $row->client_contact_name;
                    $client_contact_position .= $row->client_contact_position;
                    $client_contact_phone .= $row->client_contact_phone;
                }
                $sheet->prependRow(5, array(
                                        '', '', '', '',
                                        'Attn. No', ': ', '',
                                        'BRAND', ': ' . $data->proposal->brand->brand_name, '',
                                        'NAMA', ': ' . $client_contact_name, ''
                                    ));

                $sheet->prependRow(6, array(
                                        'Jl Panjang 8A Kebon Jeruk Jakarta Barat', '', '', '',
                                        'Tgl Penyerahan', ': ', '',
                                        'ALAMAT', ': ', '',
                                        'JABATAN', ': ' . $client_contact_position, ''
                                    ));

                $sheet->prependRow(7, array(
                                        'Telp 5330150 ext. 32143', '', '', '',
                                        '', '', '',
                                        '', '', '',
                                        'NO. CP', ': ' . $client_contact_phone, ''
                                    ));

                $sheet->prependRow(8, array(
                    ''
                ));

                $sheet->prependRow(9, array(
                                        'No',
                                        'Type',
                                        'Media',
                                        'Tgl Tayang',
                                        'Jenis Iklan',
                                        'Jenis Omzet',
                                        'Ins',
                                        'Gross/Ins',
                                        'Disc(%)', 
                                        'Netto',
                                        'PO Klien',
                                        'Omzet Internal',
                                        'Remarks'
                                    ));

                $sheet->appendRow(array(
                                        '','','','','','',
                                        'Total',
                                        $data->summary_total_gross,
                                        $data->summary_total_disc,
                                        $data->summary_total_nett,
                                        '',
                                        $data->summary_total_internal_omzet,
                                        ''
                                    ));

                $sheet->appendRow(array(''));

                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');
                $sheet->mergeCells('A3:C3');
                $sheet->mergeCells('A4:C4');
                $sheet->mergeCells('A5:C5');
                $sheet->mergeCells('A6:C6');
                $sheet->mergeCells('A7:C7');
                $sheet->mergeCells('A8:C8');

                $sheet->mergeCells('E2:G2');
                $sheet->mergeCells('F3:G3');
                $sheet->mergeCells('F4:G4');
                $sheet->mergeCells('F5:G5');
                $sheet->mergeCells('F6:G6');
                $sheet->mergeCells('F7:G7');
                $sheet->mergeCells('F8:G8');

                $sheet->mergeCells('H2:J2');
                $sheet->mergeCells('I3:J3');
                $sheet->mergeCells('I4:J4');
                $sheet->mergeCells('I5:J5');
                $sheet->mergeCells('I6:J6');
                $sheet->mergeCells('I7:J7');
                $sheet->mergeCells('I8:J8');

                $sheet->mergeCells('L2:M2');
                $sheet->mergeCells('L3:M3');
                $sheet->mergeCells('L4:M4');
                $sheet->mergeCells('L5:M5');
                $sheet->mergeCells('L6:M6');
                $sheet->mergeCells('L7:M7');
                $sheet->mergeCells('L8:M8');

                $sheet->setBorder('A2:M7', 'thin');
                $sheet->setBorder('A9:M9', 'thin');


            });



        })->export('xlsx');
    }

    public function action(Request $request, $flow_no, $id)
    {
        if(Gate::denies('Summary-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $flow = new FlowLibrary;
        $url = $flow->getCurrentUrl($this->flow_group_id, $flow_no);

        return redirect($url . $flow_no . '/' . $id);
    }

    public function postAction(Request $request, $flow_no, $id)
    {
        return redirect('workorder/summary');
    }

    public function approve(Request $request, $flow_no, $id)
    {
        $summary = Summary::find($id);

        $data['summary'] = Summary::with(
                    'summaryitems', 
                    'proposal', 
                    'proposal.brand', 
                    'proposal.medias', 
                    'proposal.client', 
                    'proposal.client.clienttype', 
                    'proposal.client_contacts', 
                    'proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                )->whereHas('summaryitems', function($query) use ($summary){
                    $query->where('revision_no', $summary->revision_no);
                })->find($id);

        return view('vendor.material.workorder.summary.approve', $data);
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        $this->validate($request, [
            'approval' => 'required',
            'messages' => 'required',
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $summary = Summary::find($id);
            $manual_user = $request->input('manual_user');

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $summary->flow_no, $request->user()->user_id, $summary->pic, $summary->created_by->user_id, $manual_user);

            $summary->flow_no = $nextFlow['flow_no'];
            $summary->current_user = $nextFlow['current_user'];
            $summary->updated_by = $request->user()->user_id;
            $summary->save();

            $his = new SummaryHistory;
            $his->summary_id = $id;
            $his->approval_type_id = 2;
            $his->summary_history_text = $request->input('messages');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'summaryapproval', $summary->summary_id);
            $this->notif->remove($request->user()->user_id, 'summaryrejected', $summary->summary_id);

            if($summary->flow_no!=98){
                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryapproval', 'You have to check summary "' . $summary->summary_order_no . '".', $id);
            }else{
                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryfinished', 'Summary "' . $summary->summary_order_no . '" has been finished.', $id);
            }
            

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $summary = Summary::find($id);
            $manual_user = $request->input('manual_user');

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $summary->flow_no, $request->user()->user_id, $summary->pic, $summary->created_by->user_id, $manual_user);

            $summary->flow_no = $prevFlow['flow_no'];
            $summary->revision_no = $summary->revision_no + 1;
            $summary->current_user = $prevFlow['current_user'];
            $summary->updated_by = $request->user()->user_id;
            $summary->save();

            $his = new SummaryHistory;
            $his->summary_id = $id;
            $his->approval_type_id = 3;
            $his->summary_history_text = $request->input('messages');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'summaryapproval', $summary->summary_id);
            $this->notif->remove($request->user()->user_id, 'summaryrejected', $summary->summary_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'summaryrejected', 'Summary "' . $summary->summary_order_no . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

        return redirect('workorder/summary');
    }
}
