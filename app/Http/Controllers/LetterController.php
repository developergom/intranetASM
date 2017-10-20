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
use App\Flow;
use App\Letter;
use App\LetterHistory;
use App\LetterType;
use App\UploadFile;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\GeneratorLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class LetterController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/secretarial/orderletter';
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
        if(Gate::denies('Order Letter-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.secretarial.orderletter.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Gate::denies('Order Letter-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data['lettertypes'] = LetterType::where('active', '1')->orderBy('letter_type_name', 'asc')->get();

        return view('vendor.material.secretarial.orderletter.create', $data);
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
            'letter_type_id' => 'required',
            'letter_to' => 'required',
            'letter_notes' => 'required',
            'contract_id[]' => 'array'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new Letter;
        $obj->letter_type_id = $request->input('letter_type_id');
        $obj->letter_to = $request->input('letter_to');
        $obj->letter_notes = $request->input('letter_notes');
        $obj->letter_source = $request->input('ORDER');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->revision_no = 0;
        $obj->letter_source = 'ORDER';
        $obj->pic = $nextFlow['current_user'];
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        if(!empty($request->input('contract_id'))) {
            Letter::find($obj->letter_id)->contracts()->sync($request->input('contract_id'));
        }

        $his = new LetterHistory;
        $his->letter_id = $obj->letter_id;
        $his->approval_type_id = 1;
        $his->letter_history_text = $request->input('letter_notes');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'orderorderletterapproval', 'Please check Order Letter from "' . $request->user()->user_firstname . '"', $obj->letter_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('secretarial/orderletter');
    }

    public function show($id)
    {
    	if(Gate::denies('Order Letter-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data['letter'] = Letter::with('contracts', 'contracts.proposal', 'lettertype', 'letterhistories')->find($id);

        return view('vendor.material.secretarial.orderletter.show', $data);
    }

    public function edit($id)
    {
    	if(Gate::denies('Order Letter-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data['lettertypes'] = LetterType::where('active', '1')->orderBy('letter_type_name', 'asc')->get();
        $data['letter'] = Letter::with([
        						'contracts', 
        						'contracts.proposal', 
        						'lettertype', 
        						'letterhistories' => function($query) { $query->orderBy('created_at', 'desc')->limit(1); }, 
        					])->find($id);

        return view('vendor.material.secretarial.orderletter.edit', $data);
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
            'letter_type_id' => 'required',
            'letter_to' => 'required',
            'letter_notes' => 'required',
            'contract_id[]' => 'array'
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = Letter::find($id);
        $obj->letter_type_id = $request->input('letter_type_id');
        $obj->letter_to = $request->input('letter_to');
        $obj->letter_notes = $request->input('letter_notes');
        $obj->flow_no = $nextFlow['flow_no'];
        $obj->current_user = $nextFlow['current_user'];
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $his = new LetterHistory;
        $his->letter_id = $id;
        $his->approval_type_id = 1;
        $his->letter_history_text = $request->input('letter_notes');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'orderletterrejected', $id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'orderletterapproval', 'Please check Order Letter from ' . $request->user()->user_firstname . '.', $id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('secretarial/orderletter');
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
            $data['rows'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.current_user')
                                ->where('letters.flow_no','<>','98')
                                ->where('letters.active', '=', '1')
                                ->where('letter_source', 'ORDER')
                                ->where('letters.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate)
                                            ->orWhere('letters.pic', $request->user()->user_id)
                                            ->orWhereIn('letters.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.current_user')
                                ->where('letters.flow_no','<>','98')
                                ->where('letters.active', '=', '1')
                                ->where('letter_source', 'ORDER')
                                ->where('letters.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate)
                                            ->orWhere('letters.pic', $request->user()->user_id)
                                            ->orWhereIn('letters.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();    
        }elseif($listtype == 'needchecking') {
            $data['rows'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letter_source', 'ORDER')
                                ->where('letters.flow_no','<>','98')
                                ->where('letters.flow_no','<>','99')
                                ->where('letters.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letter_source', 'ORDER')
                                ->where('letters.flow_no','<>','98')
                                ->where('letters.flow_no','<>','99')
                                ->where('letters.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] =  Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letter_source', 'ORDER')
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate)
                                            ->orWhere('letters.pic', $request->user()->user_id)
                                            ->orWhereIn('letters.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letter_source', 'ORDER')
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate)
                                            ->orWhere('letters.pic', $request->user()->user_id)
                                            ->orWhereIn('letters.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','0')
                                ->where('letter_source', 'ORDER')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate)
                                            ->orWhere('letters.pic', $request->user()->user_id)
                                            ->orWhereIn('letters.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','0')
                                ->where('letter_source', 'ORDER')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate)
                                            ->orWhere('letters.pic', $request->user()->user_id)
                                            ->orWhereIn('letters.pic', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Order Letter-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('letter_id');

        $obj = Letter::find($id);

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
        if(Gate::denies('Order Letter-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $flow = new FlowLibrary;
        $url = $flow->getCurrentUrl($this->flow_group_id, $flow_no);

        return redirect($url . $flow_no . '/' . $id);
    }

    public function postAction(Request $request, $flow_no, $id)
    {
        return redirect('secretarial/orderletter');
    }

    public function approve(Request $request, $flow_no, $id)
    {
        $data['letter'] = Letter::with('contracts', 'contracts.proposal', 'lettertype', 'letterhistories')->find($id);

        return view('vendor.material.secretarial.orderletter.approve', $data);
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
            $letter = Letter::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $letter->flow_no, $request->user()->user_id, '', $letter->created_by->user_id);

            $letter->flow_no = $nextFlow['flow_no'];
            $letter->current_user = $nextFlow['current_user'];
            $letter->updated_by = $request->user()->user_id;
            $letter->save();

            $fileArray = $this->upload_process($request, $letter->revision_no);

            if(!empty($fileArray)) {
	            Letter::find($id)->uploadfiles()->syncWithoutDetaching($fileArray);    
	        }

            $his = new LetterHistory;
            $his->letter_id = $id;
            $his->approval_type_id = 2;
            $his->letter_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'orderletterapproval', $letter->letter_id);
            $this->notif->remove($request->user()->user_id, 'orderletterrejected', $letter->letter_id);

            if($letter->flow_no!=98){
                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'orderletterapproval', 'You have to check Order Letter from ' . $request->user()->user_firstname . '.', $id);
            }else{
                //generate letter no
                $generator = new GeneratorLibrary;
                $code = $generator->letter_no($id);

                $upd = Letter::find($id);
                $upd->letter_no = $code['letter_no'];
                $upd->param_no = $code['param_no'];
                $upd->save();

                $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'orderletterfinished', 'Order Letter ' . $code['letter_no'] . ' has been finished.', $id);
            }
            
            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $letter = Letter::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $letter->flow_no, $request->user()->user_id, '', $letter->created_by->user_id);

            $letter->flow_no = $prevFlow['flow_no'];
            $letter->revision_no = $letter->revision_no + 1;
            $letter->current_user = $prevFlow['current_user'];
            $letter->updated_by = $request->user()->user_id;
            $letter->save();

            $fileArray = $this->upload_process($request, $letter->revision_no);

            if(!empty($fileArray)) {
	            Letter::find($id)->uploadfiles()->syncWithoutDetaching($fileArray);    
	        }

            $his = new LetterHistory;
            $his->letter_id = $id;
            $his->approval_type_id = 3;
            $his->letter_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'orderletterapproval', $letter->letter_id);
            $this->notif->remove($request->user()->user_id, 'orderletterrejected', $letter->letter_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'orderletterrejected', 'Order Letter from ' . $request->user()->user_firstname . ' rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

        return redirect('secretarial/orderletter');
    }

    private function upload_process(Request $request, $revision_no) 
    {
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
                $upl->upload_file_revision = $revision_no;
                $upl->upload_file_desc = '';
                $upl->active = '1';
                $upl->created_by = $request->user()->user_id;

                $upl->save();

                array_push($fileArray, $upl->upload_file_id);
                $fileArray[$upl->upload_file_id] = [ 'revision_no' => $revision_no ];
            }
        }

        return $fileArray;
    }
}
