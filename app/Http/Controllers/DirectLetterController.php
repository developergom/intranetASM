<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\Contract;
use App\Letter;
use App\LetterHistory;
use App\LetterType;
use App\UploadFile;
use App\User;

use App\Ibrol\Libraries\GeneratorLibrary;
use App\Ibrol\Libraries\UserLibrary;

class DirectLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Direct Letter-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.secretarial.directletter.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Gate::denies('Direct Letter-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data['lettertypes'] = LetterType::where('active', '1')->orderBy('letter_type_name', 'asc')->get();

        return view('vendor.material.secretarial.directletter.create', $data);
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

        $obj = new Letter;
        $obj->letter_type_id = $request->input('letter_type_id');
        $obj->letter_to = $request->input('letter_to');
        $obj->letter_notes = $request->input('letter_notes');
        $obj->letter_source = $request->input('ORDER');
        $obj->flow_no = 98;
        $obj->current_user = $request->user()->user_id;
        $obj->revision_no = 0;
        $obj->letter_source = 'DIRECT';
        $obj->pic = $request->user()->user_id;
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        //generate letter no
        $generator = new GeneratorLibrary;
        $code = $generator->letter_no($obj->letter_id);

        $upd = Letter::find($obj->letter_id);
        $upd->letter_no = $code['letter_no'];
        $upd->param_no = $code['param_no'];
        $upd->save();

        $fileArray = $this->upload_process($request, $obj->revision_no);

        if(!empty($fileArray)) {
            Letter::find($obj->letter_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

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

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('secretarial/directletter');
    }

    public function show($id)
    {
    	if(Gate::denies('Direct Letter-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data['letter'] = Letter::with('contracts', 'contracts.proposal', 'lettertype', 'letterhistories')->find($id);

        return view('vendor.material.secretarial.directletter.show', $data);
    }

    public function edit($id)
    {
    	if(Gate::denies('Direct Letter-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data['letter'] = Letter::with('contracts', 'contracts.proposal', 'lettertype', 'letterhistories')->find($id);
        $data['lettertypes'] = LetterType::where('active', '1')->orderBy('letter_type_name', 'asc')->get();

        return view('vendor.material.secretarial.directletter.edit', $data);
    }

    public function update(Request $request, $id)
    {
    	$this->validate($request, [
            'letter_type_id' => 'required',
            'letter_to' => 'required',
            'letter_notes' => 'required',
            'contract_id[]' => 'array'
        ]);

        $obj = Letter::find($id);
        $obj->letter_type_id = $request->input('letter_type_id');
        $obj->letter_to = $request->input('letter_to');
        $obj->letter_notes = $request->input('letter_notes');
        $obj->letter_source = $request->input('ORDER');
        $obj->flow_no = 98;
        $obj->current_user = $request->user()->user_id;
        $obj->revision_no = $obj->revision_no + 1;
        $obj->letter_source = 'DIRECT';
        $obj->pic = $request->user()->user_id;
        $obj->active = '1';
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $fileArray = $this->upload_process($request, $obj->revision_no);

        if(!empty($fileArray)) {
            Letter::find($obj->letter_id)->uploadfiles()->syncWithoutDetaching($fileArray);    
        }

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

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('secretarial/directletter');
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'updated_at';
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
        $data['rows'] =  Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letter_source', 'DIRECT')
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($request){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhere('letters.pic', $request->user()->user_id);
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
                                ->where('letter_source', 'DIRECT')
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($request){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhere('letters.pic', $request->user()->user_id);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Direct Letter-Delete')) {
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
