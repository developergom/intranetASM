<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use BrowserDetect;
use App\Http\Requests;
use App\Creative;
use App\CreativeFormat;
use App\CreativeHistory;
use App\Media;
use App\MediaCategory;
use App\Unit;
use App\UploadFile;
use App\User;

use App\Ibrol\Libraries\FlowLibrary;
use App\Ibrol\Libraries\NotificationLibrary;
use App\Ibrol\Libraries\UserLibrary;

class CreativeController extends Controller
{
    private $flows;
    private $flow_group_id;
    private $uri = '/plan/creativeplan';
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
        if(Gate::denies('Creative Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.plan.creative.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Gate::denies('Creative Plan-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['creativeformats'] = CreativeFormat::where('active', '1')->orderBy('creative_format_name')->get();
        $data['mediacategories'] = MediaCategory::where('active', '1')->orderBy('media_category_name')->get();
        $data['units'] = Unit::where('active', '1')->orderBy('unit_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        return view('vendor.material.plan.creative.create', $data);
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
            'creative_format_id' => 'required',
            'creative_name' => 'required|max:100',
            'media_category_id' => 'required',
            'creative_width' => 'required|numeric',
            'creative_height' => 'required|numeric',
            'unit_id' => 'required',
            'creative_desc' => 'required',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = new Creative;
        $obj->creative_format_id = $request->input('creative_format_id');
        $obj->creative_name = $request->input('creative_name');
        $obj->media_category_id = $request->input('media_category_id');
        $obj->creative_width = $request->input('creative_width');
        $obj->creative_height = $request->input('creative_height');
        $obj->unit_id = $request->input('unit_id');
        $obj->creative_desc = $request->input('creative_desc');
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
            Creative::find($obj->creative_id)->uploadfiles()->sync($fileArray);    
        }

        if(!empty($request->input('media_id'))) {
            Creative::find($obj->creative_id)->medias()->sync($request->input('media_id'));
        }

        $his = new CreativeHistory;
        $his->creative_id = $obj->creative_id;
        $his->approval_type_id = 1;
        $his->creative_history_text = $request->input('creative_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'creativeapproval', 'Please check Creative Plan "' . $obj->creative_name . '"', $obj->creative_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('plan/creativeplan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if(Gate::denies('Creative Plan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['creative'] = Creative::with('creativeformat', 'creativehistories', 'creativehistories.approvaltype', 'unit', 'mediacategory')->find($id);

        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['uploadedfiles'] = $data['creative']->uploadfiles()->where('revision_no', $data['creative']->revision_no)->get();

        return view('vendor.material.plan.creative.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(Gate::denies('Creative Plan-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['creative'] = Creative::with('creativeformat', 'creativehistories', 'creativehistories.approvaltype', 'unit', 'mediacategory')->find($id);
        $data['creativeformats'] = CreativeFormat::where('active', '1')->orderBy('creative_format_name')->get();
        $data['mediacategories'] = MediaCategory::where('active', '1')->orderBy('media_category_name')->get();
        $data['units'] = Unit::where('active', '1')->orderBy('unit_name')->get();
        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['uploadedfiles'] = $data['creative']->uploadfiles()->where('revision_no', $data['creative']->revision_no)->get();

        return view('vendor.material.plan.creative.edit', $data);
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
            'creative_format_id' => 'required',
            'creative_name' => 'required|max:100',
            'media_category_id' => 'required',
            'creative_width' => 'required|numeric',
            'creative_height' => 'required|numeric',
            'unit_id' => 'required',
            'creative_desc' => 'required',
            'media_id[]' => 'array',
        ]);

        $flow = new FlowLibrary;
        $nextFlow = $flow->getNextFlow($this->flow_group_id, 1, $request->user()->user_id);

        $obj = Creative::find($id);
        $obj->creative_format_id = $request->input('creative_format_id');
        $obj->creative_name = $request->input('creative_name');
        $obj->media_category_id = $request->input('media_category_id');
        $obj->creative_width = $request->input('creative_width');
        $obj->creative_height = $request->input('creative_height');
        $obj->unit_id = $request->input('unit_id');
        $obj->creative_desc = $request->input('creative_desc');
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
            Creative::find($obj->creative_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

        if(!empty($request->input('media_id'))) {
            Creative::find($obj->creative_id)->medias()->sync($request->input('media_id'));
        }

        $his = new CreativeHistory;
        $his->creative_id = $obj->creative_id;
        $his->approval_type_id = 1;
        $his->creative_history_text = $request->input('creative_desc');
        $his->active = '1';
        $his->created_by = $request->user()->user_id;

        $his->save();

        $this->notif->remove($request->user()->user_id, 'creativereject', $obj->creative_id);
        $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'creativeapproval', 'Please check Creative Plan "' . $obj->creative_name . '"', $obj->creative_id);

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('plan/creativeplan');
    }

    public function apiList($listtype, Request $request)
    {
        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'creative_id';
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
            $data['rows'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.flow_no','<>','98')
                                ->where('creatives.active', '=', '1')
                                ->where('creatives.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('creatives.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('creatives.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.flow_no','<>','98')
                                ->where('creatives.active', '=', '1')
                                ->where('creatives.current_user', '<>' , $request->user()->user_id)
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('creatives.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('creatives.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'needchecking') {
            $data['rows'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.active','1')
                                ->where('creatives.flow_no','<>','98')
                                ->where('creatives.flow_no','<>','99')
                                ->where('creatives.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.active','1')
                                ->where('creatives.flow_no','<>','98')
                                ->where('creatives.flow_no','<>','99')
                                ->where('creatives.current_user', '=' , $request->user()->user_id)
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'finished') {
            $data['rows'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.active','1')
                                ->where('creatives.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('creatives.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('creatives.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.active','1')
                                ->where('creatives.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('creatives.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('creatives.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }elseif($listtype == 'canceled') {
            $data['rows'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('creatives.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('creatives.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Creative::join('creative_formats','creative_formats.creative_format_id', '=', 'creatives.creative_format_id')
            					->join('media_categories','media_categories.media_category_id', '=', 'creatives.media_category_id')
                                ->join('users','users.user_id', '=', 'creatives.current_user')
                                ->where('creatives.active','0')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('creatives.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('creatives.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('creative_format_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_width','like','%' . $searchPhrase . '%')
                                            ->orWhere('creative_height','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }
        

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Creative Plan-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('creative_id');

        $obj = Creative::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            $his = new CreativeHistory;
            $his->creative_id = $id;
            $his->approval_type_id = 3;
            $his->creative_history_text = 'Deleting';
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'creativereject', $obj->creative_id);
            $this->notif->remove($request->user()->user_id, 'creativeapproval', $obj->creative_id);
            $this->notif->remove($request->user()->user_id, 'creativefinished', $obj->creative_id);

            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
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

        return redirect('plan/creativeplan');
    }

    private function approveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Creative Plan-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['creative'] = Creative::with('creativeformat', 'creativehistories', 'creativehistories.approvaltype', 'unit', 'mediacategory')->find($id);

        $data['medias'] = Media::whereHas('users', function($query) use($request){
                            $query->where('users_medias.user_id', '=', $request->user()->user_id);
                        })->where('medias.active', '1')->orderBy('media_name')->get();

        $medias = array();
        foreach ($data['medias'] as $key => $value) {
            array_push($medias, $value['media_id']);
        }

        $data['uploadedfiles'] = $data['creative']->uploadfiles()->where('revision_no', $data['creative']->revision_no)->get();

        return view('vendor.material.plan.creative.approve', $data);
    }

    private function postApproveFlowNo2(Request $request, $id)
    {
        if(Gate::denies('Creative Plan-Approval')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'approval' => 'required',
            'comment' => 'required',
        ]);

        if($request->input('approval') == '1') 
        {
            //approve
            $creative = Creative::find($id);

            $flow = new FlowLibrary;
            $nextFlow = $flow->getNextFlow($this->flow_group_id, $creative->flow_no, $request->user()->user_id, '', $creative->created_by->user_id);

            $creative->flow_no = $nextFlow['flow_no'];
            $creative->current_user = $nextFlow['current_user'];
            $creative->updated_by = $request->user()->user_id;
            $creative->save();

            $his = new CreativeHistory;
            $his->creative_id = $id;
            $his->approval_type_id = 2;
            $his->creative_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'creativeapproval', $creative->creative_id);
            $this->notif->generate($request->user()->user_id, $nextFlow['current_user'], 'creativefinished', 'Creative Plan "' . $creative->creative_name . '" has been approved.', $id);

            $request->session()->flash('status', 'Data has been saved!');

        }else{
            //reject
            $creative = Creative::find($id);

            $flow = new FlowLibrary;
            $prevFlow = $flow->getPreviousFlow($this->flow_group_id, $creative->flow_no, $request->user()->user_id, '', $creative->created_by->user_id);

            $creative->flow_no = $prevFlow['flow_no'];
            $creative->revision_no = $creative->revision_no + 1;
            $creative->current_user = $prevFlow['current_user'];
            $creative->updated_by = $request->user()->user_id;
            $creative->save();

            $his = new CreativeHistory;
            $his->creative_id = $id;
            $his->approval_type_id = 3;
            $his->creative_history_text = $request->input('comment');
            $his->active = '1';
            $his->created_by = $request->user()->user_id;

            $his->save();

            $this->notif->remove($request->user()->user_id, 'creativeapproval', $creative->creative_id);
            $this->notif->generate($request->user()->user_id, $prevFlow['current_user'], 'creativereject', 'Creative Plan "' . $creative->creative_name . '" rejected.', $id);

            $request->session()->flash('status', 'Data has been saved!');
        }

    }
}
