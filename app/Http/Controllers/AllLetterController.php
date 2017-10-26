<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use File;
use Gate;
use App\Http\Requests;
use App\Letter;
use App\LetterHistory;
use App\LetterType;
use App\UploadFile;

class AllLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('View All Letter-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.secretarial.allletter.list', $data);
    }

    public function show($id)
    {
    	if(Gate::denies('View All Letter-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data['letter'] = Letter::with('contracts', 'contracts.proposal', 'lettertype', 'letterhistories')->find($id);

        return view('vendor.material.secretarial.allletter.show', $data);
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
        $data['rows'] =  Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to', 'letter_source' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_to','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_source','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })
                                ->skip($skip)->take($rowCount)
                                ->orderBy($sort_column, $sort_type)->get();
            $data['total'] = Letter::select('letters.letter_id', 'letter_type_name', 'letter_no', 'letter_to', 'letter_source' ,'user_firstname', 'letters.updated_at', 'letters.flow_no')
                                ->join('letter_types', 'letter_types.letter_type_id', '=', 'letters.letter_type_id')
                                ->join('users','users.user_id', '=', 'letters.created_by')
                                ->where('letters.active','1')
                                ->where('letters.flow_no','=','98')
                                ->where(function($query) use($searchPhrase) {
                                    $query->orWhere('letter_type_name','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_no','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_to','like','%' . $searchPhrase . '%')
                                            ->orWhere('letter_source','like','%' . $searchPhrase . '%')
                                            ->orWhere('user_firstname','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }
}
