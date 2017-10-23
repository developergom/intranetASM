<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Excel;
use File;
use Gate;
use App\Http\Requests;
use App\Contract;
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
use App\UploadFile;
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

        return view('vendor.material.workorder.summary.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $contract_id)
    {
        if(Gate::denies('Summary-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data['contract'] = Contract::with(
                                        'proposal',
                                        'proposal.proposaltype', 
                                        'proposal.proposalmethod', 
                                        'proposal.proposalstatus',
                                        'proposal.industries', 
                                        'proposal.client_contacts',
                                        'proposal.client',
                                        'proposal.brand',
                                        'proposal.medias',
                                        'proposal.uploadfiles',
                                        'proposal.inventoriesplanner'
                                        )->find($contract_id);

        //forget session
        /*if($request->session()->has('summary_details_' . $request->user()->user_id)) {
            $request->session()->forget('summary_details_' . $request->user()->user_id);
        }*/

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
        //dd($request->all());

        $this->validate($request,
            [
                'contract_id' => 'required|numeric',
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

        if(!$this->hotValidation($request))
        {
            return redirect()->back()->withInput();
        }

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $contract = Contract::with('proposal')->find($request->input('contract_id'));

        $obj = new Summary;
        $obj->contract_id = $request->input('contract_id');
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
        $code = $generator->summary_order_no($obj->summary_id);

        $obj->param_no = $code['param_no'];
        $obj->summary_order_no = $code['summary_order_no'];
        $obj->save();
        //
        
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
            Summary::find($obj->summary_id)->uploadfiles()->sync($fileArray);    
        }

        $this->hotInsertion($request, $obj, $contract);

        $his = new SummaryHistory;
        $his->summary_id = $obj->summary_id;
        $his->approval_type_id = 1;
        $his->summary_history_text = $request->input('messages');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryapproval', 'You have to check summary "' . $obj->summary_order_no . '".', $obj->summary_id);

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

        $data['summary'] = Summary::with([
                    'summaryitems' => function($query) { $query->orderBy('summary_item_termin', 'asc'); }, 
                    'uploadfiles',
                    'contract',
                    'contract.proposal', 
                    'contract.proposal.brand', 
                    'contract.proposal.medias', 
                    'contract.proposal.client', 
                    'contract.proposal.client.clienttype', 
                    'contract.proposal.client_contacts', 
                    'contract.proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                ])->find($id);

        return view('vendor.material.workorder.summary.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(Gate::denies('Summary-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $summary = Summary::find($id);

        $data['summary'] = Summary::with([
                    'summaryitems' => function($query) { $query->orderBy('summary_item_termin', 'asc'); }, 
                    'summaryhistories' => function($query) { $query->orderBy('created_at', 'desc')->limit(1); }, 
                    'uploadfiles',
                    'contract',
                    'contract.proposal', 
                    'contract.proposal.brand', 
                    'contract.proposal.medias', 
                    'contract.proposal.client', 
                    'contract.proposal.client.clienttype', 
                    'contract.proposal.client_contacts', 
                    'contract.proposal.industries',
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                ])->find($id);


        $data['contract'] = Contract::with(
                                        'proposal',
                                        'proposal.proposaltype', 
                                        'proposal.proposalmethod', 
                                        'proposal.proposalstatus',
                                        'proposal.industries', 
                                        'proposal.client_contacts',
                                        'proposal.client',
                                        'proposal.brand',
                                        'proposal.medias',
                                        'proposal.uploadfiles',
                                        'proposal.inventoriesplanner'
                                        )->find($summary->contract_id);

        if($data['summary']->summaryitems->count() > 0)
        {
            $details = array();
            $no = 1;
            foreach($data['summary']->summaryitems as $key => $value)
            {
                if($value->revision_no==$summary->revision_no-1)
                {
                    $arr = [
                        $no,
                        $value->summary_item_type,
                        $value->rate->rate_name,
                        $value->rate->media->media_name,
                        ($value->summary_item_period_start=='0000-00-00') ? '' : Carbon::createFromFormat('Y-m-d', $value->summary_item_period_start)->format('d/m/Y'),
                        ($value->summary_item_period_end=='0000-00-00') ? '' : Carbon::createFromFormat('Y-m-d', $value->summary_item_period_end)->format('d/m/Y'),
                        $value->omzettype->omzet_type_name,
                        $value->summary_item_insertion,
                        $value->summary_item_gross,
                        $value->summary_item_disc,
                        $value->summary_item_nett,
                        $value->summary_item_internal_omzet,
                        $value->summary_item_remarks,
                        $value->summary_item_termin,
                        $value->summary_item_viewed,
                        $value->summary_item_edited,
                        $value->page_no,
                        $value->summary_item_canal,
                        $value->summary_item_order_digital,
                        $value->summary_item_materi,
                        $value->summary_item_status_materi,
                        $value->summary_item_capture_materi,
                        $value->summary_item_sales_order,
                        $value->summary_item_po_perjanjian,
                        $value->summary_item_ppn,
                        $value->summary_item_total
                    ];

                    array_push($details, $arr);
                    $no++;
                }
            }

            //untuk array kosong
            $empArr = ['','','','','','','','','','','','','','','','','','','','','','','','','',''];
            array_push($details, $empArr);

            //store details to session
            if($request->session()->has('summary_details_' . $request->user()->user_id)) {
                $request->session()->forget('summary_details_' . $request->user()->user_id);
            }

            $request->session()->put('summary_details_' . $request->user()->user_id, $details);
        }
        

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
        $this->validate($request,
            [
                'contract_id' => 'required|numeric',
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

        if(!$this->hotValidation($request))
        {
            return redirect()->back()->withInput();
        }

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $contract = Contract::with('proposal')->find($request->input('contract_id'));

        $obj = Summary::find($id);
        $obj->contract_id = $request->input('contract_id');
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
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        //update SummaryItem Active to 0
        $updatedSummaryItem = SummaryItem::where('summary_id', $id)->update(['active'=>0]);

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
            Summary::find($obj->summary_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        $hot = $request->session()->get('summary_details_' . $request->user()->user_id);

        for($i = 0;$i < (count($hot)-1);$i++)
        {
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
            $detail->summary_item_edited = $hot[$i][15];
            $detail->page_no = $hot[$i][16];
            $detail->summary_item_canal = $hot[$i][17];
            $detail->summary_item_order_digital = $hot[$i][18];
            $detail->summary_item_materi = $hot[$i][19];
            $detail->summary_item_status_materi = $hot[$i][20];
            $detail->summary_item_capture_materi = $hot[$i][21];
            $detail->summary_item_sales_order = $hot[$i][22];
            $detail->summary_item_po_perjanjian = $hot[$i][23];
            $detail->summary_item_ppn = $hot[$i][24];
            $detail->summary_item_total = $hot[$i][25];
            $detail->summary_item_task_status = 0;
            $detail->source_type = 'SUMMARY';
            $detail->client_id = $contract->proposal->client_id;
            $detail->industry_id = $contract->proposal->brand->subindustry->industry->industry_id;
            $detail->summary_item_title = $contract->proposal->proposal_name;
            $detail->sales_id = $request->user()->user_id;
            $detail->revision_no = $obj->revision_no;
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

        $this->notif->remove($request->user()->user_id, 'summaryapproval', $obj->summary_id);
        $this->notif->remove($request->user()->user_id, 'summaryrejected', $obj->summary_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryapproval', 'You have to check summary "' . $obj->summary_order_no . '".', $obj->summary_id);

        $request->session()->forget('summary_details_' . $request->user()->user_id);
        $request->session()->flash('status', 'Data has been saved!');

        return redirect('workorder/summary');
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
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
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
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
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
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
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
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
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
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                /*->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate);
                                })*/
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no', 'users.user_id')
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('users','users.user_id', '=', 'summaries.created_by')
                                ->where('summaries.active','1')
                                ->where('summaries.flow_no','=','98')
                                /*->where(function($query) use($request, $subordinate){
                                    $query->where('summaries.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('summaries.created_by', $subordinate);
                                })*/
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('summary_order_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = Summary::select('summaries.summary_id', 'summary_order_no', 'proposal_name', 'user_firstname', 'summaries.updated_at', 'proposals.proposal_id', 'summaries.flow_no')
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
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
                                ->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
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

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Summary-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('summary_id');

        $obj = Summary::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            SummaryItem::where('summary_id', $id)->update(['active' => '0', 'updated_by' => $request->user()->user_id ]);

            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiSaveDetails(Request $request)
    {

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

    public function apiExportXls($id)
    {
        if(Gate::denies('Summary-Download')) {
            abort(403, 'Unauthorized action.');
        }

        $this->exportToExcel($id);

        return response()->json(200);
    }

    public function apiGetDetails(Request $request)
    {
        $summary_id = $request->summary_id;
        $revision_no = $request->revision_no;

        $details = SummaryItem::with('rate', 'rate.media', 'omzettype')
                                    ->where('summary_id', $summary_id)
                                    ->where('revision_no', $revision_no)
                                    ->orderBy('summary_item_termin', 'asc')
                                    ->get();

        return response()->json($details);
    }

    private function exportToExcel($summary_id)
    {
        $data = Summary::with([
                            'summaryitems' => function($query) { 
                                $query->orderBy('summary_item_termin', 'asc'); 
                            }, 
                            'contract',
                            'contract.proposal', 
                            'contract.proposal.brand', 
                            'contract.proposal.medias', 
                            'contract.proposal.medias.organization', 
                            'contract.proposal', 
                            'contract.proposal.client', 
                            'contract.proposal.client.clienttype', 
                            'contract.proposal.client_contacts', 
                            'contract.proposal.industries', 
                            'summaryitems.rate', 
                            'summaryitems.rate.media', 
                            'summaryitems.omzettype'
                        ])->find($summary_id);

        $po = [];
        $po['sum'] = 0;
        foreach ($data->summaryitems as $value) {
            if($value->revision_no==$data->revision_no)
            {
                if(array_key_exists($value->summary_item_termin, $po)) {
                    $po[$value->summary_item_termin] += $value->summary_item_nett;
                }else{
                    $po[$value->summary_item_termin] = $value->summary_item_nett;
                }
                $po['sum'] += $value->summary_item_nett;
            }
        }

        Excel::create('Summary - ' . $data->contract->proposal->proposal_name . ' Revision No = ' . $data->revision_no, function($excel) use($data, $po) {

            $excel->sheet('SUMMARY', function($sheet) use($data, $po) {

                $summaryitems = array();
                $no = 1;
                $termin_before = 1;
                foreach($data->summaryitems as $key => $value)
                {
                    if($value->revision_no==$data->revision_no)
                    {
                        $item = array(
                                    $no,
                                    $value->summary_item_type,
                                    $value->rate->media->media_name,
                                    ($value->summary_item_period_end!='0000-00-00') ? $value->summary_item_period_start . ' s/d ' . $value->summary_item_period_end : $value->summary_item_period_start,
                                    $value->rate->rate_name,
                                    $value->omzettype->omzet_type_name,
                                    $value->summary_item_insertion,
                                    $value->summary_item_gross,
                                    $value->summary_item_disc,
                                    $value->summary_item_nett,
                                    ($value->summary_item_termin==$termin_before) ? $po[$value->summary_item_termin] : '',
                                    $value->summary_item_internal_omzet,
                                    $value->summary_item_remarks
                                );

                        array_push($summaryitems, $item);
                        $no++;

                        if($value->summary_item_termin==$termin_before){
                            $termin_before++;
                        }
                    }

                }

                $sheet->fromArray($summaryitems);

                $sheet->prependRow(2, array(
                    'NAMA PT', '', '', 'SALES AGENT', 'ORDER FO', '', '', 'INDUSTRY/BRAND', '', '', 'PAYER', ': ' . $data->contract->proposal->client->clienttype->client_type_name, ''
                ));

                $industry = '';
                foreach($data->contract->proposal->industries as $row){
                    $industry .= $row->industry_name . ', ';
                }

                $media = '';
                $organization = '';
                foreach($data->contract->proposal->medias as $row){
                    $media .= $row->media_name . ', ';
                    $organization .= $row->organization->organization_name . ', ';
                }

                $sheet->prependRow(3, array(
                                        $organization, '', '',
                                        $data->contract->proposal->created_by->user_firstname . ' ' . $data->contract->proposal->created_by->user_lastname,
                                        'NO ORDER', ': ' . $data->summary_order_no, '',
                                        'INDUSTRY', ': ' . $industry, '',
                                        'BILL TO PARTY', ': ' . $data->contract->proposal->client->client_name, ''
                                    ));

                $sheet->prependRow(4, array(
                                        '', '', '', '',
                                        'MEDIA', ': ' . $media, '',
                                        'COMPANY', ':', '',
                                        'PIC', '', ''
                                    ));

                $client_contact_name = '';
                $client_contact_position = '';
                $client_contact_phone = '';
                foreach($data->contract->proposal->client_contacts as $row){
                    $client_contact_name .= $row->client_contact_name;
                    $client_contact_position .= $row->client_contact_position;
                    $client_contact_phone .= $row->client_contact_phone;
                }
                $sheet->prependRow(5, array(
                                        '', '', '', '',
                                        'Attn. No', ': ', '',
                                        'BRAND', ': ' . $data->contract->proposal->brand->brand_name, '',
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
                                        $po['sum'],
                                        $data->summary_total_internal_omzet,
                                        ''
                                    ));

                $sheet->appendRow(array(''));

                $sheet->appendRow(array('Keterangan:'));
                $sheet->appendRow(array(strip_tags($data->summary_notes)));

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
        $data['summary'] = Summary::with([
                    'summaryitems' => function($query) { $query->orderBy('summary_item_termin', 'asc'); }, 
                    'uploadfiles',
                    'contract',
                    'contract.proposal', 
                    'contract.proposal.brand', 
                    'contract.proposal.medias', 
                    'contract.proposal.client', 
                    'contract.proposal.client.clienttype', 
                    'contract.proposal.client_contacts', 
                    'contract.proposal.industries', 
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                ])->find($id);

        if($data['summary']->summaryitems->count() > 0)
        {
            $details = array();
            $no = 1;
            foreach($data['summary']->summaryitems as $key => $value)
            {
                if($value->revision_no==$data['summary']->revision_no)
                {
                    $arr = [
                        $no,
                        $value->summary_item_type,
                        $value->rate->rate_name,
                        $value->rate->media->media_name,
                        ($value->summary_item_period_start=='0000-00-00') ? '' : Carbon::createFromFormat('Y-m-d', $value->summary_item_period_start)->format('d/m/Y'),
                        ($value->summary_item_period_end=='0000-00-00') ? '' : Carbon::createFromFormat('Y-m-d', $value->summary_item_period_end)->format('d/m/Y'),
                        $value->omzettype->omzet_type_name,
                        $value->summary_item_insertion,
                        $value->summary_item_gross,
                        $value->summary_item_disc,
                        $value->summary_item_nett,
                        $value->summary_item_internal_omzet,
                        $value->summary_item_remarks,
                        $value->summary_item_termin,
                        $value->summary_item_viewed,
                        $value->summary_item_edited,
                        $value->page_no,
                        $value->summary_item_canal,
                        $value->summary_item_order_digital,
                        $value->summary_item_materi,
                        $value->summary_item_status_materi,
                        $value->summary_item_capture_materi,
                        $value->summary_item_sales_order,
                        $value->summary_item_po_perjanjian,
                        $value->summary_item_ppn,
                        $value->summary_item_total
                    ];

                    array_push($details, $arr);
                    $no++;
                }
            }

            //store details to session
            if($request->session()->has('summary_details_' . $request->user()->user_id)) {
                $request->session()->forget('summary_details_' . $request->user()->user_id);
            }

            $request->session()->put('summary_details_' . $request->user()->user_id, $details);
        }

        return view('vendor.material.workorder.summary.approve', $data);
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        $this->validate($request, [
            'approval' => 'required',
            'messages' => 'required',
        ]);

        if(!$this->hotValidation($request))
        {
            return redirect()->back()->withInput();
        }

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

            $contract = Contract::with('proposal')->find($summary->contract_id);

            //edit-items or no
            if($request->input('edit-items') == 'on') {
                $obj = Summary::find($id);
                $obj->summary_total_gross = $request->input('summary_total_gross');
                $obj->summary_total_disc = $request->input('summary_total_discount');
                $obj->summary_total_nett = $request->input('summary_total_nett');
                $obj->summary_total_internal_omzet = $request->input('summary_total_internal_omzet');
                $obj->summary_total_media_cost = $request->input('summary_total_media_cost');
                $obj->summary_total_cost_pro = $request->input('summary_total_cost_pro');
                $obj->revision_no = $summary->revision_no + 1;
                $obj->updated_by = $request->user()->user_id;

                $obj->save();

                //update SummaryItem Active to 0
                $updatedSummaryItem = SummaryItem::where('summary_id', $id)->update(['active'=>0]);

                $hot = $request->session()->get('summary_details_' . $request->user()->user_id);

                for($i = 0;$i < (count($hot)-1);$i++)
                {
                    $rate = Rate::where('rate_name', $hot[$i][2])->where('active', 1)->first();
                    $omzettype = OmzetType::where('omzet_type_name', $hot[$i][6])->where('active', 1)->first();

                    $detail = new SummaryItem;
                    $detail->rate_id = $rate->rate_id;
                    $detail->summary_id = $summary->summary_id;
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
                    $detail->summary_item_edited = $hot[$i][15];
                    $detail->page_no = $hot[$i][16];
                    $detail->summary_item_canal = $hot[$i][17];
                    $detail->summary_item_order_digital = $hot[$i][18];
                    $detail->summary_item_materi = $hot[$i][19];
                    $detail->summary_item_status_materi = $hot[$i][20];
                    $detail->summary_item_capture_materi = $hot[$i][21];
                    $detail->summary_item_sales_order = $hot[$i][22];
                    $detail->summary_item_po_perjanjian = $hot[$i][23];
                    $detail->summary_item_ppn = $hot[$i][24];
                    $detail->summary_item_total = $hot[$i][25];
                    $detail->summary_item_task_status = 0;
                    $detail->source_type = 'SUMMARY';
                    $detail->client_id = $contract->proposal->client_id;
                    $detail->industry_id = $contract->proposal->brand->subindustry->industry->industry_id;
                    $detail->summary_item_title = $contract->proposal->proposal_name;
                    $detail->sales_id = $request->user()->user_id;
                    $detail->revision_no = $summary->revision_no + 1;
                    $detail->active = '1';
                    $detail->created_by = $contract->created_by->user_id;
                    if($hot[$i][15]=='YES') {
                        $detail->updated_by = $request->user()->user_id;
                    }

                    $detail->save();
                }
            }
            //end edit-items or notif

            $his = new SummaryHistory;
            $his->summary_id = $id;
            $his->approval_type_id = 2;
            $his->summary_history_text = $request->input('messages');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $request->session()->forget('summary_details_' . $request->user()->user_id);
            $this->notif->remove($request->user()->user_id, 'summaryapproval', $summary->summary_id);
            $this->notif->remove($request->user()->user_id, 'summaryrejected', $summary->summary_id);

            if($summary->flow_no!=98){
                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryapproval', 'You have to check summary "' . $summary->summary_order_no . '".', $id);
            }else{
                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryfinished', 'Summary "' . $summary->summary_order_no . '" has been finished.', $id);

                //send notifications to SPTD FO
                $sptdfo = User::whereHas('roles', function($q){ $q->where('role_name', 'Superintendent FO'); })->first();
                $this->notif->generate($request->user()->user_id, $sptdfo->user_name, 'summarydelivered', 'Summary "' . $summary->summary_order_no . '" has been delivered.', $id);
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

            $contract = Contract::with('proposal')->find($summary->contract_id);

            //edit-items or no
            if($request->input('edit-items') == 'on') {
                $obj = Summary::find($id);
                $obj->summary_total_gross = $request->input('summary_total_gross');
                $obj->summary_total_disc = $request->input('summary_total_discount');
                $obj->summary_total_nett = $request->input('summary_total_nett');
                $obj->summary_total_internal_omzet = $request->input('summary_total_internal_omzet');
                $obj->summary_total_media_cost = $request->input('summary_total_media_cost');
                $obj->summary_total_cost_pro = $request->input('summary_total_cost_pro');
                $obj->revision_no = $summary->revision_no + 1;
                $obj->updated_by = $request->user()->user_id;

                $obj->save();

                //update SummaryItem Active to 0
                $updatedSummaryItem = SummaryItem::where('summary_id', $id)->update(['active'=>0]);

                $hot = $request->session()->get('summary_details_' . $request->user()->user_id);

                for($i = 0;$i < (count($hot)-1);$i++)
                {
                    $rate = Rate::where('rate_name', $hot[$i][2])->where('active', 1)->first();
                    $omzettype = OmzetType::where('omzet_type_name', $hot[$i][6])->where('active', 1)->first();

                    $detail = new SummaryItem;
                    $detail->rate_id = $rate->rate_id;
                    $detail->summary_id = $summary->summary_id;
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
                    $detail->summary_item_edited = $hot[$i][15];
                    $detail->page_no = $hot[$i][16];
                    $detail->summary_item_canal = $hot[$i][17];
                    $detail->summary_item_order_digital = $hot[$i][18];
                    $detail->summary_item_materi = $hot[$i][19];
                    $detail->summary_item_status_materi = $hot[$i][20];
                    $detail->summary_item_capture_materi = $hot[$i][21];
                    $detail->summary_item_sales_order = $hot[$i][22];
                    $detail->summary_item_po_perjanjian = $hot[$i][23];
                    $detail->summary_item_ppn = $hot[$i][24];
                    $detail->summary_item_total = $hot[$i][25];
                    $detail->summary_item_task_status = 0;
                    $detail->source_type = 'SUMMARY';
                    $detail->client_id = $contract->proposal->client_id;
                    $detail->industry_id = $contract->proposal->brand->subindustry->industry->industry_id;
                    $detail->summary_item_title = $contract->proposal->proposal_name;
                    $detail->sales_id = $request->user()->user_id;
                    $detail->revision_no = $summary->revision_no;
                    $detail->active = '1';
                    $detail->created_by = $contract->created_by->user_id;
                    if($hot[$i][15]=='YES') {
                        $detail->updated_by = $request->user()->user_id;
                    }

                    $detail->save();
                }
            }
            //end edit-items or notif

            $his = new SummaryHistory;
            $his->summary_id = $id;
            $his->approval_type_id = 3;
            $his->summary_history_text = $request->input('messages');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $request->session()->forget('summary_details_' . $request->user()->user_id);
            $this->notif->remove($request->user()->user_id, 'summaryapproval', $summary->summary_id);
            $this->notif->remove($request->user()->user_id, 'summaryrejected', $summary->summary_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'summaryrejected', 'Summary "' . $summary->summary_order_no . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

        return redirect('workorder/summary');
    }

    public function renew(Request $request, $id)
    {
        if(Gate::denies('Summary-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $summary = Summary::find($id);

        $data['summary'] = Summary::with([
                    'summaryitems' => function($query) { $query->orderBy('summary_item_termin', 'asc'); }, 
                    'summaryhistories' => function($query) { $query->orderBy('created_at', 'desc')->limit(1); }, 
                    'uploadfiles',
                    'contract',
                    'contract.proposal', 
                    'contract.proposal.brand', 
                    'contract.proposal.medias', 
                    'contract.proposal.client', 
                    'contract.proposal.client.clienttype', 
                    'contract.proposal.client_contacts', 
                    'contract.proposal.industries',
                    'summaryitems.rate', 
                    'summaryitems.rate.media', 
                    'summaryitems.omzettype'
                ])->find($id);


        $data['contract'] = Contract::with(
                                        'proposal',
                                        'proposal.proposaltype', 
                                        'proposal.proposalmethod', 
                                        'proposal.proposalstatus',
                                        'proposal.industries', 
                                        'proposal.client_contacts',
                                        'proposal.client',
                                        'proposal.brand',
                                        'proposal.medias',
                                        'proposal.uploadfiles',
                                        'proposal.inventoriesplanner'
                                        )->find($summary->contract_id);

        if($data['summary']->summaryitems->count() > 0)
        {
            $details = array();
            $no = 1;
            foreach($data['summary']->summaryitems as $key => $value)
            {
                if($value->revision_no==$summary->revision_no)
                {
                    $arr = [
                        $no,
                        $value->summary_item_type,
                        $value->rate->rate_name,
                        $value->rate->media->media_name,
                        ($value->summary_item_period_start=='0000-00-00') ? '' : Carbon::createFromFormat('Y-m-d', $value->summary_item_period_start)->format('d/m/Y'),
                        ($value->summary_item_period_end=='0000-00-00') ? '' : Carbon::createFromFormat('Y-m-d', $value->summary_item_period_end)->format('d/m/Y'),
                        $value->omzettype->omzet_type_name,
                        $value->summary_item_insertion,
                        $value->summary_item_gross,
                        $value->summary_item_disc,
                        $value->summary_item_nett,
                        $value->summary_item_internal_omzet,
                        $value->summary_item_remarks,
                        $value->summary_item_termin,
                        $value->summary_item_viewed,
                        $value->summary_item_edited,
                        $value->page_no,
                        $value->summary_item_canal,
                        $value->summary_item_order_digital,
                        $value->summary_item_materi,
                        $value->summary_item_status_materi,
                        $value->summary_item_capture_materi,
                        $value->summary_item_sales_order,
                        $value->summary_item_po_perjanjian,
                        $value->summary_item_ppn,
                        $value->summary_item_total
                    ];

                    array_push($details, $arr);
                    $no++;
                }
            }

            //untuk array kosong
            $empArr = ['','','','','','','','','','','','','','','','','','','','','','','','','',''];
            array_push($details, $empArr);

            //store details to session
            if($request->session()->has('summary_details_' . $request->user()->user_id)) {
                $request->session()->forget('summary_details_' . $request->user()->user_id);
            }

            $request->session()->put('summary_details_' . $request->user()->user_id, $details);
        }
        

        return view('vendor.material.workorder.summary.renew', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postRenew(Request $request, $id)
    {
        $this->validate($request,
            [
                'contract_id' => 'required|numeric',
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

        if(!$this->hotValidation($request))
        {
            return redirect()->back()->withInput();
        }

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $contract = Contract::with('proposal')->find($request->input('contract_id'));

        $obj = Summary::find($id);
        $obj->contract_id = $request->input('contract_id');
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
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $obj->revision_no + 1];
            }
        }

        if(!empty($fileArray)) {
            Summary::find($obj->summary_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        //update SummaryItem Active to 0
        $updatedSummaryItem = SummaryItem::where('summary_id', $id)->update(['active'=>0]);

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
            $detail->summary_item_edited = $hot[$i][15];
            $detail->page_no = $hot[$i][16];
            $detail->summary_item_canal = $hot[$i][17];
            $detail->summary_item_order_digital = $hot[$i][18];
            $detail->summary_item_materi = $hot[$i][19];
            $detail->summary_item_status_materi = $hot[$i][20];
            $detail->summary_item_capture_materi = $hot[$i][21];
            $detail->summary_item_sales_order = $hot[$i][22];
            $detail->summary_item_po_perjanjian = $hot[$i][23];
            $detail->summary_item_ppn = $hot[$i][24];
            $detail->summary_item_total = $hot[$i][25];
            $detail->summary_item_task_status = 0;
            $detail->source_type = 'SUMMARY';
            $detail->client_id = $contract->proposal->client_id;
            $detail->industry_id = $contract->proposal->brand->subindustry->industry->industry_id;
            $detail->summary_item_title = $contract->proposal->proposal_name;
            $detail->sales_id = $request->user()->user_id;
            $detail->revision_no = $obj->revision_no;
            $detail->active = '1';
            $detail->created_by = $contract->proposal->created_by->user_id;

            $detail->save();
        }

        $his = new SummaryHistory;
        $his->summary_id = $obj->summary_id;
        $his->approval_type_id = 1;
        $his->summary_history_text = $request->input('messages');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'summaryapproval', $obj->summary_id);
        $this->notif->remove($request->user()->user_id, 'summaryrejected', $obj->summary_id);
        $this->notif->remove($request->user()->user_id, 'summaryfinished', $obj->summary_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'summaryapproval', 'Please check Summary', $obj->summary_id);

        $request->session()->forget('summary_details_' . $request->user()->user_id);
        $request->session()->flash('status', 'Data has been saved!');

        return redirect('workorder/summary');
    }

    public function apiGeneratePosisiIklan(Request $request)
    {
        $media_id = $request->input('media_id');
        $year = $request->input('year');
        $month = $request->input('month');
        $view_type = $request->input('view_type');
        $edition_date = Carbon::createFromFormat('d/m/Y', $request->input('edition_date'))->toDateString();
        $summary_item_type = $request->input('summary_item_type');
        
        if($view_type=='digital'){ //digital
             $items = SummaryItem::join('clients', 'clients.client_id', '=', 'summary_items.client_id')
                            ->join('rates', 'rates.rate_id', '=', 'summary_items.rate_id')
                            ->join('medias', 'medias.media_id', '=', 'rates.media_id')
                            ->join('users', 'users.user_id', '=', 'summary_items.created_by')
                            ->join('units', 'units.unit_id', '=', 'rates.unit_id')
                            ->join('industries', 'industries.industry_id', '=', 'summary_items.industry_id')
                            ->where('rates.media_id', $media_id)
                            ->where('summary_items.active', '1')
                            ->where('summary_items.summary_item_type', $summary_item_type)
                            ->whereYear('summary_item_period_start', '=', $year)
                            ->whereMonth('summary_item_period_start', '=', $month)
                            ->orderBy('summary_item_period_start', 'asc')
                            ->get();

        }elseif($view_type=='print'){ //print
            $dates = SummaryItem::select('summary_item_period_start')
                            ->join('rates', 'rates.rate_id', '=', 'summary_items.rate_id')
                            ->where('summary_items.active', '1')
                            ->where('summary_items.summary_item_type', $summary_item_type)
                            ->where('rates.media_id', $media_id)
                            ->where('summary_item_period_start', $edition_date)
                            ->groupBy('summary_item_period_start')
                            ->get();

            $items = array();
            foreach ($dates as $value) {
                $item = SummaryItem::join('clients', 'clients.client_id', '=', 'summary_items.client_id')
                            ->join('rates', 'rates.rate_id', '=', 'summary_items.rate_id')
                            ->join('medias', 'medias.media_id', '=', 'rates.media_id')
                            ->join('users', 'users.user_id', '=', 'summary_items.created_by')
                            ->join('units', 'units.unit_id', '=', 'rates.unit_id')
                            ->join('industries', 'industries.industry_id', '=', 'summary_items.industry_id')
                            ->where('rates.media_id', $media_id)
                            ->where('summary_items.active', '1')
                            ->where('summary_items.summary_item_type', $summary_item_type)
                            ->where('summary_item_period_start', $value->summary_item_period_start)
                            ->orderBy('summary_item_period_start', 'asc')
                            ->get();

                array_push($items, ['items' => $item, 'index' => $value->summary_item_period_start]);
            }

            
        }

       


        return response()->json($items);
    }

    private function checkRateName($rate_name)
    {
        $rate = Rate::where('rate_name', '=', $rate_name)->where('active', '1')->count();

        if($rate > 0)
            return true;

        return false;
    }

    private function checkMediaName($media_name)
    {
        $rate = Media::where('media_name', '=', $media_name)->where('active', '1')->count();

        if($rate > 0)
            return true;

        return false;
    }

    private function checkOmzetTypeName($omzet_type_name)
    {
        $rate = OmzetType::where('omzet_type_name', '=', $omzet_type_name)->where('active', '1')->count();

        if($rate > 0)
            return true;

        return false;
    }

    private function hotValidation(Request $request)
    {
        $hot = $request->session()->get('summary_details_' . $request->user()->user_id);
        for($i = 0;$i < (count($hot)-1);$i++)
        {
            if($this->checkRateName($hot[$i][2])==false){
                $request->session()->flash('rateNameFailed', 'The rate you have been entered is not valid at row ' . ($i+1) . '!');
                return false;
            }

            if($this->checkMediaName($hot[$i][3])==false){
                $request->session()->flash('mediaNameFailed', 'The media you have been entered is not valid at row ' . ($i+1) . '!');
                return false;
            }

            if($this->checkOmzetTypeName($hot[$i][6])==false){
                $request->session()->flash('omzetTypeNameFailed', 'The omzet type you have been entered is not valid at row ' . ($i+1) . '!');
                return false;
            }
        }

        return true;
    }

    private function hotInsertion(Request $request, $obj, $contract)
    {
        $hot = $request->session()->get('summary_details_' . $request->user()->user_id);
        for($i = 0;$i < (count($hot)-1);$i++)
        {
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
            $detail->summary_item_edited = $hot[$i][15];
            $detail->page_no = $hot[$i][16];
            $detail->summary_item_canal = $hot[$i][17];
            $detail->summary_item_order_digital = $hot[$i][18];
            $detail->summary_item_materi = $hot[$i][19];
            $detail->summary_item_status_materi = $hot[$i][20];
            $detail->summary_item_capture_materi = $hot[$i][21];
            $detail->summary_item_sales_order = $hot[$i][22];
            $detail->summary_item_sales_order = $hot[$i][23];
            $detail->summary_item_ppn = $hot[$i][24];
            $detail->summary_item_total = $hot[$i][25];
            $detail->summary_item_task_status = 0;
            $detail->source_type = 'SUMMARY';
            $detail->client_id = $contract->proposal->client_id;
            $detail->industry_id = $contract->proposal->brand->subindustry->industry->industry_id;
            $detail->summary_item_title = $contract->proposal->proposal_name;
            $detail->sales_id = $request->user()->user_id;
            $detail->revision_no = 0;
            $detail->active = '1';
            $detail->created_by = $request->user()->user_id;

            $detail->save();
        }
    }
}
