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
}
