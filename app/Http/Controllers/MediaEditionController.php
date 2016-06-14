<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use App\Http\Requests;
use App\MediaEdition;

class MediaEditionController extends Controller
{
    public function apiSave(Request $request)
    {
        $this->validate($request, [
            'media_id' => 'required',
            'media_edition_no' => 'required|max:50',
            'media_edition_publish_date' => 'required',
            'media_edition_deadline_date' => 'required',
        ]);

        $obj = new MediaEdition;

        $obj->media_id = $request->input('media_id');
        $obj->media_edition_no = $request->input('media_edition_no');
        $obj->media_edition_publish_date = Carbon::createFromFormat('d/m/Y', $request->input('media_edition_publish_date'))->toDateString();
        $obj->media_edition_deadline_date = Carbon::createFromFormat('d/m/Y', $request->input('media_edition_deadline_date'))->toDateString();
        $obj->media_edition_desc = $request->input('media_edition_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiList(Request $request)
    {
        $id = $request->input('id');

        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 5;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'media_edition_id';
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
        $data['rows'] = MediaEdition::join('medias','medias.media_id','=','media_editions.media_id')
                            ->where('media_editions.active','1')
                            ->where('media_editions.media_id',$id)
                            ->where(function($query) use($searchPhrase) {
                                $query->where('media_edition_no','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_edition_publish_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_edition_deadline_date','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = MediaEdition::join('medias','medias.media_id','=','media_editions.media_id')
                            ->where('media_editions.active','1')
                            ->where('media_editions.media_id',$id)
                            ->where(function($query) use($searchPhrase) {
                                $query->where('media_edition_no','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_edition_publish_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_edition_deadline_date','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }


    public function apiEdit(Request $request)
    {
        $id = $request->input('media_edition_id');

        $obj = MediaEdition::find($id);

        $obj->media_edition_no = $request->input('media_edition_no');
        $obj->media_edition_publish_date = Carbon::createFromFormat('d/m/Y', $request->input('media_edition_publish_date'))->toDateString();
        $obj->media_edition_deadline_date = Carbon::createFromFormat('d/m/Y', $request->input('media_edition_deadline_date'))->toDateString();
        $obj->media_edition_desc = $request->input('media_edition_desc');
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }   
    }


    public function apiDelete(Request $request)
    {
        $id = $request->input('media_edition_id');

        $obj = MediaEdition::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
