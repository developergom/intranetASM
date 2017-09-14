<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\AdvertiseRateType;
use App\Color;
use App\Media;
use App\Paper;
use App\Rate;
use App\SpotType;
use App\Studio;
use App\Unit;

class RateController extends Controller
{
	public $cols = [
                        [
                            'key' => 'parent_id',
                            'text' => 'Package Rate'
                        ],
                        [ 
                            'key' => 'advertise_rate_type_id',
                            'text' => 'Rate Type'
                        ],
                        [ 
                            'key' => 'media_id',
                            'text' => 'Media'
                        ],
                        [ 
                            'key' => 'rate_name',
                            'text' => 'Rate Name'
                        ],
                        [ 
                            'key' => 'width',
                            'text' => 'Width'
                        ],
                        [ 
                            'key' => 'length',
                            'text' => 'Length'
                        ],
                        [ 
                            'key' => 'unit_id',
                            'text' => 'Unit (cm,mm,px,etc)'
                        ],
                        [ 
                            'key' => 'studio_id',
                            'text' => 'Studio'
                        ],
                        [ 
                            'key' => 'duration',
                            'text' => 'Duration'
                        ],
                        [ 
                            'key' => 'duration_type',
                            'text' => 'Duration Type'
                        ],
                        [ 
                            'key' => 'spot_type_id',
                            'text' => 'Spot Type'
                        ],
                        [ 
                            'key' => 'gross_rate',
                            'text' => 'Gross Rate'
                        ],
                        [ 
                            'key' => 'discount',
                            'text' => 'Discount'
                        ],
                        [ 
                            'key' => 'nett_rate',
                            'text' => 'Nett Rate'
                        ],
                        [ 
                            'key' => 'start_valid_date',
                            'text' => 'Start Valid Date'
                        ],
                        [ 
                            'key' => 'end_valid_date',
                            'text' => 'End Valid Date'
                        ],
                        [ 
                            'key' => 'cinema_tax',
                            'text' => 'Cinema Tax'
                        ],
                        [ 
                            'key' => 'paper_id',
                            'text' => 'Paper'
                        ],
                        [ 
                            'key' => 'color_id',
                            'text' => 'Color'
                        ]     
                    ];

    private $duration_types = ['second', 'minute', 'hour'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Gate::denies('Rates Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.material.master.rate.list');
    }

    public function create()
    {
        if(Gate::denies('Rates Management-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['parents'] = Rate::with('media')->where('active', '1')->where('parent_id', '0')->orderBy('rate_name')->get();
        $data['advertiseratetypes'] = AdvertiseRateType::where('active', '1')->orderBy('advertise_rate_type_name')->get();
        $data['colors'] = Color::where('active', '1')->orderBy('color_name')->get();
        $data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();
        $data['papers'] = Paper::where('active', '1')->orderBy('paper_name')->get();
        $data['durationtypes'] = $this->duration_types;
        $data['spottypes'] = SpotType::where('active', '1')->orderBy('spot_type_name')->get();
        $data['studios'] = Studio::where('active', '1')->orderBy('studio_name')->get();
        $data['units'] = Unit::where('active', '1')->orderBy('unit_name')->get();

        return view('vendor.material.master.rate.create', $data);
    }

    public function store(Request $request)
    {
        $advertiseratetype = AdvertiseRateType::find($request->input('advertise_rate_type_id'));
        $requiredFields = unserialize($advertiseratetype->advertise_rate_required_fields);

        //dynamic validation
        $dynamic_validation = array();
        foreach ($requiredFields as $value) {
            $dynamic_validation[$value] ='required';
        }

        $this->validate($request, $dynamic_validation);

        $obj = new Rate;

        $obj->parent_id = $request->input('parent_id');
        $obj->advertise_rate_type_id = $request->input('advertise_rate_type_id');
        $obj->media_id = $request->input('media_id');
        $obj->rate_name = $request->input('rate_name');
        $obj->width = $request->input('width');
        $obj->length = $request->input('length');
        $obj->unit_id = $request->input('unit_id');
        $obj->studio_id = $request->input('studio_id');
        $obj->duration = $request->input('duration');
        $obj->duration_type = $request->input('duration_type');
        $obj->spot_type_id = $request->input('spot_type_id');
        $obj->gross_rate = $request->input('gross_rate');
        $obj->discount = $request->input('discount');
        $obj->nett_rate = $request->input('nett_rate');
        $obj->start_valid_date = Carbon::createFromFormat('d/m/Y', $request->input('start_valid_date'))->toDateString();
        $obj->end_valid_date = Carbon::createFromFormat('d/m/Y', $request->input('end_valid_date'))->toDateString();
        $obj->cinema_tax = $request->input('cinema_tax');
        $obj->paper_id = $request->input('paper_id');
        $obj->color_id = $request->input('color_id');
        $obj->active = '1';
        $obj->created_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been saved!');

        return redirect('master/rate');

    }

    public function show($id)
    {
        if(Gate::denies('Rates Management-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['rate'] = Rate::with('parent',
                                    'child',
                                    'advertiseratetype',
                                    'color',
                                    'paper',
                                    'media',
                                    'spottype',
                                    'studio',
                                    'unit')->where('rates.active', '1')->find($id);

        //dd($data);

        $data['advertiseratetypes'] = AdvertiseRateType::where('active', '1')->orderBy('advertise_rate_type_name')->get();
        $data['colors'] = Color::where('active', '1')->orderBy('color_name')->get();
        $data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();
        $data['papers'] = Paper::where('active', '1')->orderBy('paper_name')->get();
        $data['durationtypes'] = $this->duration_types;
        $data['spottypes'] = SpotType::where('active', '1')->orderBy('spot_type_name')->get();
        $data['studios'] = Studio::where('active', '1')->orderBy('studio_name')->get();
        $data['units'] = Unit::where('active', '1')->orderBy('unit_name')->get();
        $data['start_valid_date'] = Carbon::createFromFormat('Y-m-d', ($data['rate']->start_valid_date==null) ? date('Y-m-d') : $data['rate']->start_valid_date)->format('d/m/Y');
        $data['end_valid_date'] = Carbon::createFromFormat('Y-m-d', ($data['rate']->end_valid_date==null) ? date('Y-m-d') : $data['rate']->end_valid_date)->format('d/m/Y');

        return view('vendor.material.master.rate.show', $data);
    }

    public function edit($id)
    {
        if(Gate::denies('Rates Management-Update')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['rate'] = Rate::where('active', '1')->find($id);

        $data['parents'] = Rate::with('media')->where('active', '1')->where('parent_id', '0')->orderBy('rate_name')->get();
        $data['advertiseratetypes'] = AdvertiseRateType::where('active', '1')->orderBy('advertise_rate_type_name')->get();
        $data['colors'] = Color::where('active', '1')->orderBy('color_name')->get();
        $data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();
        $data['papers'] = Paper::where('active', '1')->orderBy('paper_name')->get();
        $data['durationtypes'] = $this->duration_types;
        $data['spottypes'] = SpotType::where('active', '1')->orderBy('spot_type_name')->get();
        $data['studios'] = Studio::where('active', '1')->orderBy('studio_name')->get();
        $data['units'] = Unit::where('active', '1')->orderBy('unit_name')->get();
        $data['start_valid_date'] = Carbon::createFromFormat('Y-m-d', ($data['rate']->start_valid_date==null) ? date('Y-m-d') : $data['rate']->start_valid_date)->format('d/m/Y');
        $data['end_valid_date'] = Carbon::createFromFormat('Y-m-d', ($data['rate']->end_valid_date==null) ? date('Y-m-d') : $data['rate']->end_valid_date)->format('d/m/Y');

        return view('vendor.material.master.rate.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $advertiseratetype = AdvertiseRateType::find($request->input('advertise_rate_type_id'));
        $requiredFields = unserialize($advertiseratetype->advertise_rate_required_fields);

        //dynamic validation
        $dynamic_validation = array();
        foreach ($requiredFields as $value) {
            $dynamic_validation[$value] ='required';
        }

        $this->validate($request, $dynamic_validation);

        $obj = Rate::find($id);

        $obj->advertise_rate_type_id = $request->input('advertise_rate_type_id');
        $obj->media_id = $request->input('media_id');
        $obj->rate_name = $request->input('rate_name');
        $obj->width = $request->input('width');
        $obj->length = $request->input('length');
        $obj->unit_id = $request->input('unit_id');
        $obj->studio_id = $request->input('studio_id');
        $obj->duration = $request->input('duration');
        $obj->duration_type = $request->input('duration_type');
        $obj->spot_type_id = $request->input('spot_type_id');
        $obj->gross_rate = $request->input('gross_rate');
        $obj->discount = $request->input('discount');
        $obj->nett_rate = $request->input('nett_rate');
        $obj->start_valid_date = Carbon::createFromFormat('d/m/Y', $request->input('start_valid_date'))->toDateString();
        $obj->end_valid_date = Carbon::createFromFormat('d/m/Y', $request->input('end_valid_date'))->toDateString();
        $obj->cinema_tax = $request->input('cinema_tax');
        $obj->paper_id = $request->input('paper_id');
        $obj->color_id = $request->input('color_id');
        $obj->updated_by = $request->user()->user_id;

        $obj->save();

        $request->session()->flash('status', 'Data has been updated!');

        return redirect('master/rate');
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 10;
        $skip = ($current==1) ? 0 : (($current - 1) * $rowCount);
        $searchPhrase = $request->input('searchPhrase') or '';
        
        $sort_column = 'rate_id';
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
        $data['rows'] = Rate::join('advertise_rate_types','advertise_rate_types.advertise_rate_type_id','=','rates.advertise_rate_type_id')
                            ->where('rates.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('advertise_rate_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('end_valid_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('nett_rate','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Rate::join('advertise_rate_types','advertise_rate_types.advertise_rate_type_id','=','rates.advertise_rate_type_id')
                            ->where('rates.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('advertise_rate_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('end_valid_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('nett_rate','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }

    public function apiDelete(Request $request)
    {
        if(Gate::denies('Rates Management-Delete')) {
            abort(403, 'Unauthorized action.');
        }

        $id = $request->input('rate_id');

        $obj = Rate::find($id);

        $obj->active = '0';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }

    public function apiGetAll(Request $request)
    {
        $pos = Rate::select('rate_id', 'rate_name')->where('active', '1')->where('rate_name','like','%' . $request->input('query') . '%')->orderBy('rate_name')->limit(5)->get();

        $result = array();
        foreach ($pos as $value) {
            array_push($result, $value->rate_name);
        }

        return response()->json($result);
    }

    public function apiGetByName(Request $request)
    {
        $rate = Rate::with('media')->where('rate_name', $request->input('rate_name'))->first();

        return response()->json($rate);
    }
}
