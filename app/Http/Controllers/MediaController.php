<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Media;
use App\MediaCategory;
use App\MediaEdition;
use App\MediaGroup;
use App\Publisher;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Media Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.media.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Gate::denies('Media Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['publisher'] = Publisher::where('active', '1')->orderBy('publisher_name')->get();
        //$data['mediagroup'] = MediaGroup::where('active','1')->orderBy('media_group_name')->get();
        $data['mediacategory'] = MediaCategory::where('active','1')->orderBy('media_category_name')->get();
        return view('vendor.material.master.media.create', $data);
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
            'media_group_id' => 'required',
            'media_category_id' => 'required',
            'media_code' => 'required|max:12|unique:medias,media_code',
            'media_name' => 'required|max:100',
            'media_logo' => 'image|max:2000',
            'media_circulation' => 'numeric',
        ]);

        if ($request->hasFile('media_logo')) {
            if ($request->file('media_logo')->isValid()) {
                $uploaded = $request->file('media_logo');
                $media_logo = Carbon::now()->format('YmdHis') . $uploaded->getClientOriginalName();
                $uploaded->move(
                    base_path() . '/public/img/media/logo/', $media_logo
                );
            }else{
                $media_logo = 'logo.jpg';    
            }
        }else{
            $media_logo = 'logo.jpg';
        }

        $obj = new Media;

        $obj->media_category_id = $request->input('media_category_id');
        $obj->media_group_id = $request->input('media_group_id');
        $obj->media_code = $request->input('media_code');
        $obj->media_name = $request->input('media_name');
        $obj->media_logo = $media_logo;
        $obj->media_circulation = $request->input('media_circulation');
        $obj->media_desc = $request->input('media_desc');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/media');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Gate::denies('Media Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['media'] = Media::where('active','1')->find($id);
        return view('vendor.material.master.media.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Gate::denies('Media Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();
        $data['publisher'] = Publisher::where('active', '1')->orderBy('publisher_name')->get();
        $data['mediagroup'] = MediaGroup::where('active','1')->orderBy('media_group_name')->get();
        $data['mediacategory'] = MediaCategory::where('active','1')->orderBy('media_category_name')->get();
        $data['media'] = Media::where('active','1')->find($id);
        return view('vendor.material.master.media.edit', $data);
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
            'media_group_id' => 'required',
            'media_category_id' => 'required',
            'media_code' => 'required|max:12|unique:medias,media_code,' . $id . ',media_id',
            'media_name' => 'required|max:100',
            'media_logo' => 'image|max:2000',
            'media_circulation' => 'numeric',
        ]);

        $obj = Media::find($id);

        $obj->media_category_id = $request->input('media_category_id');
        $obj->media_group_id = $request->input('media_group_id');
        $obj->media_code = $request->input('media_code');
        $obj->media_name = $request->input('media_name');
        $obj->media_circulation = $request->input('media_circulation');
        $obj->media_desc = $request->input('media_desc');
        $obj->updated_by = $request->user()->user_id;

        if ($request->hasFile('media_logo')) {
            if ($request->file('media_logo')->isValid()) {
                $uploaded = $request->file('media_logo');
                $media_logo = Carbon::now()->format('YmdHis') . $uploaded->getClientOriginalName();
                $uploaded->move(
                    base_path() . '/public/img/media/logo/', $media_logo
                );

                $obj->media_logo = $media_logo;

            }
        }

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/media');
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

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'media_id';
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
        $data['rows'] = Media::join('media_groups','media_groups.media_group_id','=','medias.media_group_id')
                            ->join('media_categories','media_categories.media_category_id','=','medias.media_category_id')
                            ->where('medias.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('media_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_name','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Media::join('media_groups','media_groups.media_group_id','=','medias.media_group_id')
                                ->join('media_categories','media_categories.media_category_id','=','medias.media_category_id')
                                ->where('medias.active','1')
                                ->where(function($query) use($searchPhrase) {
                                    $query->where('media_code','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_category_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_group_name','like','%' . $searchPhrase . '%');
                                })->count();

        return response()->json($data);
    }


    public function apiDelete(Request $request)
    {
        if(Gate::denies('Media Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('media_id');

        $obj = Media::find($id);

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
