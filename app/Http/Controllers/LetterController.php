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
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate);
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
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate);
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
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate);
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
                                ->where(function($query) use($request, $subordinate){
                                    $query->where('letters.created_by', '=' , $request->user()->user_id)
                                            ->orWhereIn('letters.created_by', $subordinate);
                                })
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();
        }

        

        return response()->json($data);
    }
}
