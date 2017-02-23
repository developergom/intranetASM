<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\GridProposal;
use App\GridProposalHistory;
use App\UploadFile;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class GridProposalController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/grid/proposal';
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
        if(Gate::denies('Grid Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.grid.proposal.list', $data);
    }

    public function create(Request $request)
    {
		if(Gate::denies('Grid Proposal-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['pics'] = User::where('active', '1')->whereHas('roles', function($query) {
                            $query->where('role_name', '=', 'GRID Lead Generation Officer');
                        })->get();

     	return view('vendor.material.grid.proposal.create', $data);   
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
            'grid_proposal_name' => 'required|max:100',
            'grid_proposal_deadline' => 'required|date_format:"d/m/Y"',
            'grid_proposal_desc' => 'required',
            'pics' => 'required'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id, $request->input('pics'), '', $request->input('pics'));

        $obj = new GridProposal;
        $obj->grid_proposal_name = $request->input('grid_proposal_name');
        $obj->grid_proposal_deadline = Carbon::createFromFormat('d/m/Y', $request->input('grid_proposal_deadline'))->toDateString();
        $obj->grid_proposal_desc = $request->input('grid_proposal_desc');
        $obj->approval_1 = $request->input('pics');
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

        //creating path
        $path = 'uploads/files/grid_proposals/' . date('Y') . '/' . date('m');
        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = $path . '/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = $path . '/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
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
            GridProposal::find($obj->grid_proposal_id)->uploadfiles()->sync($fileArray);    
        }

        $his = new GridProposalHistory;
        $his->grid_proposal_id = $obj->grid_proposal_id;
        $his->approval_type_id = 1;
        $his->grid_proposal_history_text = $request->input('grid_proposal_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $nofifdata = array();
        $nofifdata['subject'] = 'Proposal: ' . $obj->grid_proposal_name;
        $nofifdata['url'] = 'grid/proposal/approve/' . $obj->flow_no . '/' . $obj->grid_proposal_id;
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Please check GRID Proposal "' . $obj->grid_proposal_name . '"', $obj->grid_proposal_id, true, $nofifdata);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('grid/proposal');
    }

    public function show(Request $request, $id)
    {
    	if(Gate::denies('Grid Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal'] = GridProposal::with(
											'uploadfiles',
											'gridproposalhistories',
											'gridproposalhistories.approvaltype'
											)->find($id);
        $data['deadline'] = Carbon::createFromFormat('Y-m-d', ($data['proposal']->grid_proposal_deadline==null) ? date('Y-m-d') : $data['proposal']->grid_proposal_deadline)->format('d/m/Y');

        return view('vendor.material.grid.proposal.show', $data);
    }

    public function edit(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal'] = GridProposal::with(
											'uploadfiles',
											'gridproposalhistories',
											'gridproposalhistories.approvaltype'
											)->find($id);
        $data['deadline'] = Carbon::createFromFormat('Y-m-d', ($data['proposal']->grid_proposal_deadline==null) ? date('Y-m-d') : $data['proposal']->grid_proposal_deadline)->format('d/m/Y');

        return view('vendor.material.grid.proposal.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'grid_proposal_name' => 'required|max:100',
            'grid_proposal_deadline' => 'required|date_format:"d/m/Y"',
            'grid_proposal_desc' => 'required',
            'pics' => 'required'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id, $request->input('pics'), '', $request->input('pics'));

        $obj = GridProposal::find($id);
        $obj->grid_proposal_name = $request->input('grid_proposal_name');
        $obj->grid_proposal_deadline = Carbon::createFromFormat('d/m/Y', $request->input('grid_proposal_deadline'))->toDateString();
        $obj->grid_proposal_desc = $request->input('grid_proposal_desc');
        $obj->approval_1 = $request->input('pics');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->updated_by = $request->user()->user_id;

        $obj->save();


        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);

        //creating path
        $path = 'uploads/files/grid_proposals/' . date('Y') . '/' . date('m');
        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = $path . '/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = $path . '/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
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
            GridProposal::find($obj->project_task_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        $his = new GridProposalHistory;
        $his->grid_proposal_id = $obj->grid_proposal_id;
        $his->approval_type_id = 1;
        $his->grid_proposal_history_text = $request->input('grid_proposal_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $nofifdata = array();
        $nofifdata['subject'] = 'Proposal: ' . $obj->grid_proposal_name;
        $nofifdata['url'] = 'grid/proposal/approve/' . $obj->flow_no . '/' . $obj->grid_proposal_id;
        $this->notif->remove($request->user()->user_id, 'gridproposalreject', $obj->project_task_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Please check GRID Proposal "' . $obj->grid_proposal_name . '"', $obj->grid_proposal_id, true, $nofifdata);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('grid/proposal');
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'grid_proposal_id';
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
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.approval_1',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.active', '=', '1')
                                ->where('grid_proposals.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhere('grid_proposals.approval_1', $request->user()->user_id)
                                            ->orWhere('grid_proposals.pic_1', $request->user()->user_id)
                                            ->orWhere('grid_proposals.pic_2', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.approval_1', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.approval_1',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.active', '=', '1')
                                ->where('grid_proposals.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhere('grid_proposals.approval_1', $request->user()->user_id)
                                            ->orWhere('grid_proposals.pic_1', $request->user()->user_id)
                                            ->orWhere('grid_proposals.pic_2', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.approval_1', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.flow_no','<>','99')
                                ->where('grid_proposals.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','<>','98')
                                ->where('grid_proposals.flow_no','<>','99')
                                ->where('grid_proposals.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhere('grid_proposals.pic_1', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhere('grid_proposals.pic_2', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','1')
                                ->where('grid_proposals.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate)
                                            ->orWhere('grid_proposals.pic_1', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_1', $subordinate)
                                            ->orWhere('grid_proposals.pic_2', '=', $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.pic_2', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = GridProposal::select(
                                            'grid_proposals.grid_proposal_id',
                                            'grid_proposals.grid_proposal_name',
                                            'grid_proposals.grid_proposal_deadline',
                                            'grid_proposals.flow_no',
                                            'grid_proposals.pic_1',
                                            'grid_proposals.pic_2',
                                            'users.user_firstname'
                                        )
                                ->join('users','users.user_id', '=', 'grid_proposals.current_user')
                                ->where('grid_proposals.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('grid_proposals.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('grid_proposals.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('grid_proposal_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('grid_proposal_deadline','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }

    public function approve(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            return $this->approveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            return $this->approveFlowNo2($request, $id);
        }elseif($flow_no == 3) {
            return $this->approveFlowNo3($request, $id);
        }elseif($flow_no == 4) {
            return $this->approveFlowNo4($request, $id);
        }elseif($flow_no == 5) {
            return $this->approveFlowNo5($request, $id);
        }elseif($flow_no == 6) {
            return $this->approveFlowNo5($request, $id);
        }elseif($flow_no == 7) {
            return $this->approveFlowNo5($request, $id);
        }
    }

    public function postApprove(Request $request, $flow_no, $id)
    {
        if($flow_no == 1) {
            $this->postApproveFlowNo1($request, $id);
        }elseif($flow_no == 2) {
            $this->postApproveFlowNo2($request, $id);
        }elseif($flow_no == 3) {
            $this->postApproveFlowNo3($request, $id);
        }elseif($flow_no == 4) {
            $this->postApproveFlowNo4($request, $id);
        }elseif($flow_no == 5) {
            $this->postApproveFlowNo5($request, $id);
        }elseif($flow_no == 6) {
            $this->postApproveFlowNo6($request, $id);
        }elseif($flow_no == 7) {
            $this->postApproveFlowNo7($request, $id);
        }

        return redirect('grid/proposal');
    }

    private function approveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal'] = GridProposal::with(
                                            'uploadfiles',
                                            'gridproposalhistories',
                                            'gridproposalhistories.approvaltype'
                                            )->find($id);
        $data['deadline'] = Carbon::createFromFormat('Y-m-d', ($data['proposal']->grid_proposal_deadline==null) ? date('Y-m-d') : $data['proposal']->grid_proposal_deadline)->format('d/m/Y');
        $data['url'] = 'grid/proposal/approve/' . $data['proposal']->flow_no . '/' . $id;
        $data['pics'] = User::where('active', '1')->whereHas('roles', function($query) {
                            $query->where('role_name', '=', 'GRID Creative Specialist');
                        })->get();

        return view('vendor.material.grid.proposal.appform1', $data);
    }

    private function postApproveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'comment' => 'required',
            'pic' => 'required'
        ]);

        $proposal = GridProposal::find($id);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $request->input('pic'), $proposal->created_by, $request->input('pic'));

        $proposal->pic_1 = $request->input('pic');
        $proposal->flow_no = $nextFlow['flow_no'];
        $proposal->current_user = $nextFlow['current_user'];
        $proposal->updated_by = $request->user()->user_id;
        $proposal->save();

        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);

        //creating path
        $path = 'uploads/files/grid_proposals/' . date('Y') . '/' . date('m');
        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = $path . '/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = $path . '/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
            }

            if(File::move($value, $newfile)) {
                $file = pathinfo($newfile);
                $filesize = File::size($newfile);

                $upl = new UploadFile;
                $upl->upload_file_type = $file['extension'];
                $upl->upload_file_name = $file['basename'];
                $upl->upload_file_path = $file['dirname'];
                $upl->upload_file_size = $filesize;
                $upl->upload_file_revision = $proposal->revision_no;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $proposal->revision_no ];
            }
        }

        if(!empty($fileArray)) {
            GridProposal::find($proposal->grid_proposal_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        $his = new GridProposalHistory;
        $his->grid_proposal_id = $id;
        $his->approval_type_id = 1;
        $his->grid_proposal_history_text = $request->input('comment');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $nofifdata = array();
        $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
        $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
        $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
        $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Proposal "' . $proposal->grid_proposal_name . '" need approval.', $id, true, $nofifdata);

        $request->session()->flash('status', 'Data has been saved!');

    }

    private function approveFlowNo3(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal'] = GridProposal::with(
                                            'uploadfiles',
                                            'gridproposalhistories',
                                            'gridproposalhistories.approvaltype'
                                            )->find($id);
        $data['deadline'] = Carbon::createFromFormat('Y-m-d', ($data['proposal']->grid_proposal_deadline==null) ? date('Y-m-d') : $data['proposal']->grid_proposal_deadline)->format('d/m/Y');
        $data['url'] = 'grid/proposal/approve/' . $data['proposal']->flow_no . '/' . $id;
        $data['pics'] = User::where('active', '1')->whereHas('roles', function($query) {
                            $query->where('role_name', '=', 'GRID Content Production & Distribution Manager');
                        })->get();

        return view('vendor.material.grid.proposal.picform1', $data);
    }

    private function postApproveFlowNo3(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        if($request->input('skip_production')=='0') {
            $this->validate($request, [
                'comment' => 'required',
                'pic' => 'required'
            ]);

            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by, $request->input('pic'));

            $proposal->pic_2 = $request->input('pic');
        }else{
            $this->validate($request, [
                'comment' => 'required'
            ]);

            $proposal = GridProposal::find($id);

            $nextFlow['flow_no'] = 6;
            $nextFlow['current_user'] = $proposal->approval_1;
        }


        $proposal->flow_no = $nextFlow['flow_no'];
        $proposal->current_user = $nextFlow['current_user'];
        $proposal->grid_proposal_ready_date = Carbon::now()->toDateTimeString();
        $proposal->grid_proposal_delivery_date = Carbon::now()->toDateTimeString();
        $proposal->updated_by = $request->user()->user_id;
        $proposal->save();

        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);

        //creating path
        $path = 'uploads/files/grid_proposals/' . date('Y') . '/' . date('m');
        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = $path . '/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = $path . '/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
            }

            if(File::move($value, $newfile)) {
                $file = pathinfo($newfile);
                $filesize = File::size($newfile);

                $upl = new UploadFile;
                $upl->upload_file_type = $file['extension'];
                $upl->upload_file_name = $file['basename'];
                $upl->upload_file_path = $file['dirname'];
                $upl->upload_file_size = $filesize;
                $upl->upload_file_revision = $proposal->revision_no;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $proposal->revision_no ];
            }
        }

        if(!empty($fileArray)) {
            GridProposal::find($proposal->grid_proposal_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        $his = new GridProposalHistory;
        $his->grid_proposal_id = $id;
        $his->approval_type_id = 1;
        $his->grid_proposal_history_text = $request->input('comment');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $nofifdata = array();
        $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
        $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
        $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
        $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Proposal "' . $proposal->grid_proposal_name . '" need approval.', $id, true, $nofifdata);

        $request->session()->flash('status', 'Data has been saved!');

    }

    private function approveFlowNo4(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal'] = GridProposal::with(
                                            'uploadfiles',
                                            'gridproposalhistories',
                                            'gridproposalhistories.approvaltype'
                                            )->find($id);
        $data['deadline'] = Carbon::createFromFormat('Y-m-d', ($data['proposal']->grid_proposal_deadline==null) ? date('Y-m-d') : $data['proposal']->grid_proposal_deadline)->format('d/m/Y');
        $data['url'] = 'grid/proposal/approve/' . $data['proposal']->flow_no . '/' . $id;

        return view('vendor.material.grid.proposal.picform2', $data);
    }

    private function postApproveFlowNo4(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'comment' => 'required'
        ]);

        $proposal = GridProposal::find($id);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by);

        $proposal->flow_no = $nextFlow['flow_no'];
        $proposal->current_user = $nextFlow['current_user'];
        $proposal->grid_proposal_ready_date = Carbon::now()->toDateTimeString();
        $proposal->updated_by = $request->user()->user_id;
        $proposal->save();

        //file saving
        $fileArray = array();

        $tmpPath = 'uploads/tmp/' . $request->user()->user_id;
        $files = File::files($tmpPath);

        //creating path
        $path = 'uploads/files/grid_proposals/' . date('Y') . '/' . date('m');
        if(!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        foreach($files as $key => $value) {
            $oldfile = pathinfo($value);
            $newfile = $path . '/' . $oldfile['basename'];
            if(File::exists($newfile)) {
                $rand = rand(1, 100);
                $newfile = $path . '/' . $oldfile['filename'] . $rand . '.' . $oldfile['extension'];
            }

            if(File::move($value, $newfile)) {
                $file = pathinfo($newfile);
                $filesize = File::size($newfile);

                $upl = new UploadFile;
                $upl->upload_file_type = $file['extension'];
                $upl->upload_file_name = $file['basename'];
                $upl->upload_file_path = $file['dirname'];
                $upl->upload_file_size = $filesize;
                $upl->upload_file_revision = $proposal->revision_no;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $proposal->revision_no ];
            }
        }

        if(!empty($fileArray)) {
            GridProposal::find($proposal->grid_proposal_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        $his = new GridProposalHistory;
        $his->grid_proposal_id = $id;
        $his->approval_type_id = 1;
        $his->grid_proposal_history_text = $request->input('comment');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $nofifdata = array();
        $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
        $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
        $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
        $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Proposal "' . $proposal->grid_proposal_name . '" need approval.', $id, true, $nofifdata);

        $request->session()->flash('status', 'Data has been saved!');

    }

    private function approveFlowNo5(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['proposal'] = GridProposal::with(
                                            'uploadfiles',
                                            'gridproposalhistories',
                                            'gridproposalhistories.approvaltype'
                                            )->find($id);
        $data['deadline'] = Carbon::createFromFormat('Y-m-d', ($data['proposal']->grid_proposal_deadline==null) ? date('Y-m-d') : $data['proposal']->grid_proposal_deadline)->format('d/m/Y');
        $data['url'] = 'grid/proposal/approve/' . $data['proposal']->flow_no . '/' . $id;

        return view('vendor.material.grid.proposal.approve', $data);
    }

    private function postApproveFlowNo5(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required'
        ]);

        if($request->input('approval') == '1') 
        {
            //approve

            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by, $proposal->approval_1);

            $proposal->flow_no = $nextFlow['flow_no'];
            $proposal->current_user = $nextFlow['current_user'];
            $proposal->grid_proposal_delivery_date = Carbon::now()->toDateTimeString();
            $proposal->updated_by = $request->user()->user_id;
            $proposal->save();

            $his = new GridProposalHistory;
            $his->grid_proposal_id = $id;
            $his->approval_type_id = 2;
            $his->grid_proposal_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $nofifdata = array();
            $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
            $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
            $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
            $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Proposal "' . $proposal->grid_proposal_name . '" need approval.', $id, true, $nofifdata);

            $request->session()->flash('status', 'Data has been saved!');
        }else{
            //reject
            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by, $proposal->pic_1);

            $proposal->flow_no = $prevFlow['flow_no'];
            $proposal->revision_no = $proposal->revision_no + 1;
            $proposal->current_user = $prevFlow['current_user'];
            $proposal->updated_by = $request->user()->user_id;
            $proposal->save();

            $his = new GridProposalHistory;
            $his->grid_proposal_id = $id;
            $his->approval_type_id = 3;
            $his->grid_proposal_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $nofifdata = array();
            $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
            $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
            $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
            $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'gridproposalreject', 'Proposal "' . $proposal->grid_proposal_name . '" rejected.', $id, true, $nofifdata);

            $request->session()->flash('status', 'Data has been saved!');
        }
    }

    private function postApproveFlowNo6(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required'
        ]);

        if($request->input('approval') == '1') 
        {
            //approve

            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by);

            $proposal->flow_no = $nextFlow['flow_no'];
            $proposal->current_user = $nextFlow['current_user'];
            $proposal->grid_proposal_delivery_date = Carbon::now()->toDateTimeString();
            $proposal->updated_by = $request->user()->user_id;
            $proposal->save();

            $his = new GridProposalHistory;
            $his->grid_proposal_id = $id;
            $his->approval_type_id = 2;
            $his->grid_proposal_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $nofifdata = array();
            $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
            $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
            $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
            $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalapproval', 'Proposal "' . $proposal->grid_proposal_name . '" need approval.', $id, true, $nofifdata);

            $request->session()->flash('status', 'Data has been saved!');
        }else{
            //reject
            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by, $proposal->pic_1);

            $proposal->flow_no = $prevFlow['flow_no'];
            $proposal->revision_no = $proposal->revision_no + 1;
            $proposal->current_user = $prevFlow['current_user'];
            $proposal->updated_by = $request->user()->user_id;
            $proposal->save();

            $his = new GridProposalHistory;
            $his->grid_proposal_id = $id;
            $his->approval_type_id = 3;
            $his->grid_proposal_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $nofifdata = array();
            $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
            $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
            $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
            $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'gridproposalreject', 'Proposal "' . $proposal->grid_proposal_name . '" rejected.', $id, true, $nofifdata);

            $request->session()->flash('status', 'Data has been saved!');
        }
    }

    private function postApproveFlowNo7(Request $request, $id)
    {
        if(Gate::denies('Grid Proposal-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required'
        ]);

        if($request->input('approval') == '1') 
        {
            //approve

            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by);

            $proposal->flow_no = $nextFlow['flow_no'];
            $proposal->current_user = $nextFlow['current_user'];
            $proposal->grid_proposal_delivery_date = Carbon::now()->toDateTimeString();
            $proposal->updated_by = $request->user()->user_id;
            $proposal->save();

            $his = new GridProposalHistory;
            $his->grid_proposal_id = $id;
            $his->approval_type_id = 4;
            $his->grid_proposal_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
            $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'gridproposalfinish', 'Proposal "' . $proposal->grid_proposal_name . '" has been finished.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }else{
            //reject
            $proposal = GridProposal::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $proposal->flow_no, $request->user()->user_id, $proposal->pic_1, $proposal->created_by, $proposal->approval_1);

            $proposal->flow_no = $prevFlow['flow_no'];
            $proposal->revision_no = $proposal->revision_no + 1;
            $proposal->current_user = $prevFlow['current_user'];
            $proposal->updated_by = $request->user()->user_id;
            $proposal->save();

            $his = new GridProposalHistory;
            $his->grid_proposal_id = $id;
            $his->approval_type_id = 3;
            $his->grid_proposal_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $nofifdata = array();
            $nofifdata['subject'] = 'Proposal: ' . $proposal->grid_proposal_name;
            $nofifdata['url'] = 'grid/proposal/approve/' . $proposal->flow_no . '/' . $proposal->grid_proposal_id;
            $this->notif->remove($request->user()->user_id, 'gridproposalapproval', $id);
            $this->notif->remove($request->user()->user_id, 'gridproposalreject', $id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'gridproposalreject', 'Proposal "' . $proposal->grid_proposal_name . '" rejected.', $id, true, $nofifdata);

            $request->session()->flash('status', 'Data has been saved!');
        }
    }
}
