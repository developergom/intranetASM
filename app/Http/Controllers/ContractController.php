<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Excel;
use File;
use Gate;
use App\Http\Requests;
use App\Client;
use App\ClientContact;
use App\Flow;
use App\Industry;
use App\Media;
use App\Proposal;
use App\ProposalType;
use App\ProposalHistory;
use App\Rate;
use App\Contract;
use App\ContractHistory;
use App\UploadFile;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\GeneratorLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class ContractController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/workorder/contract';
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
        if(Gate::denies('Contract-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal_types'] = ProposalType::select('proposal_type_id','proposal_type_name', 'proposal_type_duration')->where('active', '1')->orderBy('proposal_type_name')->get();
        $data['industries'] = Industry::select('industry_id','industry_name')->where('active', '1')->orderBy('industry_name')->get();
        $data['medias'] = Media::select('media_id','media_name')->whereHas('users', function($query) use($request){
                                    $query->where('users_medias.user_id', '=', $request->user()->user_id);
                                })->where('medias.active', '1')->orderBy('media_name')->get();

        return view('vendor.material.workorder.contract.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $proposal_id)
    {
        if(Gate::denies('Contract-Create')) {
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

        return view('vendor.material.workorder.contract.create', $data);
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
            'proposal_id' => 'required',
            'messages' => 'required'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new Contract;
        $obj->proposal_id = $request->input('proposal_id');
        $obj->contract_date = date('Y-m-d');
        $obj->contract_notes = $request->input('contract_notes');
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
            Contract::find($obj->contract_id)->uploadfiles()->sync($fileArray);    
        }

        $his = new ContractHistory;
        $his->contract_id = $obj->contract_id;
        $his->approval_type_id = 1;
        $his->contract_history_text = $request->input('messages');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $proposal = Proposal::find($request->input('proposal_id'));
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'contractapproval', 'Please check Contract "' . $proposal->proposal_name . '"', $obj->contract_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('workorder/contract');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Contract-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data['contract'] = Contract::with(
                                        'proposal',
                                        'proposal.industries', 
                                        'proposal.client_contacts',
                                        'proposal.client',
                                        'proposal.brand',
                                        'proposal.medias',
                                        'uploadfiles', 
                                        'contracthistories')
                            ->find($id);

        return view('vendor.material.workorder.contract.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Contract-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data['contract'] = Contract::with(
                                        'proposal',
                                        'proposal.industries', 
                                        'proposal.client_contacts',
                                        'proposal.client',
                                        'proposal.brand',
                                        'proposal.medias',
                                        'uploadfiles', 
                                        'contracthistories')
                            ->find($id);

        return view('vendor.material.workorder.contract.edit', $data);
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
        $this->validate($request, [
            'messages' => 'required'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = Contract::find($id);
        $obj->contract_notes = $request->input('contract_notes');
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
            Contract::find($obj->contract_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        $his = new ContractHistory;
        $his->contract_id = $obj->contract_id;
        $his->approval_type_id = 1;
        $his->contract_history_text = $request->input('messages');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'contractrejected', $obj->contract_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'contractapproval', 'Please check Contract "' . $obj->proposal->proposal_name . '"', $obj->contract_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('workorder/contract');
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
            $data['rows'] = Contract::select('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.current_user')
                                ->where('contracts.flow_no','<>','98')
                                ->where('contracts.active', '=', '1')
                                ->where('contracts.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('contracts.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('contracts.created_by', $subordinate)
                                            ->orWhere('contracts.pic', $request->user()->user_id)
                                            ->orWhereIn('contracts.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->groupBy('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = count(Contract::select('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.current_user')
                                ->where('contracts.flow_no','<>','98')
                                ->where('contracts.active', '=', '1')
                                ->where('contracts.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('contracts.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('contracts.created_by', $subordinate)
                                            ->orWhere('contracts.pic', $request->user()->user_id)
                                            ->orWhereIn('contracts.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->groupBy('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->get());    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = Contract::select('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.created_by')
                                ->where('contracts.active','1')
                                ->where('contracts.flow_no','<>','98')
                                ->where('contracts.flow_no','<>','99')
                                ->where('contracts.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->groupBy('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = count(Contract::select('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.created_by')
                                ->where('contracts.active','1')
                                ->where('contracts.flow_no','<>','98')
                                ->where('contracts.flow_no','<>','99')
                                ->where('contracts.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->groupBy('contracts.contract_id', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->get());
        }elseif($listtype == 'finished') {
            $data['rows'] =  Contract::select('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no', 'users.user_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.created_by')
                                ->where('contracts.active','1')
                                ->where('contracts.flow_no','=','98')
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('contracts.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('contracts.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('contract_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->groupBy('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no', 'users.user_id')
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = count(Contract::select('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no', 'users.user_id')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.created_by')
                                ->where('contracts.active','1')
                                ->where('contracts.flow_no','=','98')
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('contracts.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('contracts.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('contract_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->groupBy('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no', 'users.user_id')
                                ->get());
        }elseif($listtype == 'canceled') {
            $data['rows'] = Contract::select('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.created_by')
                                ->where('contracts.active','0')
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('contracts.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('contracts.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('contract_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->groupBy('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = count(Contract::select('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                                ->join('proposal_media', 'proposal_media.proposal_id', '=', 'proposals.proposal_id')
                                ->join('proposal_industry', 'proposal_industry.proposal_id', '=', 'proposals.proposal_id')
                                ->join('users','users.user_id', '=', 'contracts.created_by')
                                ->where('contracts.active','0')
                                ->where(function($query) use($request){
                                    if($request->input('proposal_type_id')!=''){
                                        $query->whereIn('proposals.proposal_type_id', $request->input('proposal_type_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('industry_id')!=''){
                                        $query->whereIn('proposal_industry.industry_id', $request->input('industry_id'));
                                    }
                                })
                                ->where(function($query) use($request){
                                    if($request->input('media_id')!=''){
                                        $query->whereIn('proposal_media.media_id', $request->input('media_id'));
                                    }
                                })
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('contracts.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('contracts.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('proposal_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('contract_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->groupBy('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no' ,'user_firstname', 'contracts.updated_at', 'proposals.proposal_id', 'contracts.flow_no')
                                ->get());
        }

        

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Contract-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('contract_id');

        $obj = Proposal::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function action(Request $request, $flow_no, $id)
    {
        if(Gate::denies('Contract-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $flow = new FlowLibrary;
        $url = $flow->getCurrentUrl($this->flow_group_id, $flow_no);

        return redirect($url . $flow_no . '/' . $id);
    }

    public function postAction(Request $request, $flow_no, $id)
    {
        return redirect('workorder/contract');
    }

    public function approve(Request $request, $flow_no, $id)
    {
        $data['contract'] = Contract::with(
                                        'proposal',
                                        'proposal.industries', 
                                        'proposal.client_contacts',
                                        'proposal.client',
                                        'proposal.brand',
                                        'proposal.medias',
                                        'uploadfiles', 
                                        'contracthistories')
                            ->find($id);

        return view('vendor.material.workorder.contract.approve', $data);
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required',
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $contract = Contract::with('proposal')->find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $contract->flow_no, $request->user()->user_id, '', $contract->created_by->user_id);

            $contract->flow_no = $nextFlow['flow_no'];
            $contract->current_user = $nextFlow['current_user'];
            $contract->updated_by = $request->user()->user_id;
            $contract->save();

            $his = new ContractHistory;
            $his->contract_id = $id;
            $his->approval_type_id = 2;
            $his->contract_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'contractapproval', $contract->contract_id);
            $this->notif->remove($request->user()->user_id, 'contractreject', $contract->contract_id);

            if($contract->flow_no!=98){
                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'contractapproval', 'You have to check Contract "' . $contract->proposal->proposal_name . '".', $id);
            }else{
                //generate contract no
                $generator = new GeneratorLibrary;
                $code = $generator->contract_no($id);

                $upd = Contract::find($id);
                $upd->contract_no = $code['contract_no'];
                $upd->param_no = $code['param_no'];
                $upd->save();

                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'contractfinished', 'Contract "' . $contract->proposal->proposal_name . '" has been finished.', $id);
            }
            

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $contract = Contract::with('proposal')->find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $contract->flow_no, $request->user()->user_id, '', $contract->created_by->user_id);

            $contract->flow_no = $prevFlow['flow_no'];
            $contract->revision_no = $contract->revision_no + 1;
            $contract->current_user = $prevFlow['current_user'];
            $contract->updated_by = $request->user()->user_id;
            $contract->save();

            $his = new ContractHistory;
            $his->contract_id = $id;
            $his->approval_type_id = 3;
            $his->contract_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'contractapproval', $contract->contract_id);
            $this->notif->remove($request->user()->user_id, 'contractrejected', $contract->contract_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'contractrejected', 'Contract "' . $contract->proposal->proposal_name . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

        return redirect('workorder/contract');
    }

    public function apiSearch(Request $request)
    {
        if(Gate::denies('Contract-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $keyword = $request->keyword;

        $result = Contract::select('contracts.contract_id', 'contracts.contract_no', 'proposals.proposal_name')
                            ->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
                            ->where(function($query) use($keyword) {
                                    $query->orWhere('proposal_name','like','%' . $keyword . '%')
                                            ->orWhere('contract_no','like','%' . $keyword . '%');
                                })
                            ->where('contracts.created_by','=', $request->user()->user_id)
                            ->where('contracts.flow_no','98')
                            ->where('contracts.active', '1')
                            ->take(5)
                            ->orderBy('contract_no','desc')->get();

        return response()->json($result, 200);
    }
}
