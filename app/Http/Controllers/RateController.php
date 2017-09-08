<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Media;
use App\Paper;
use App\Rate;

class RateController extends Controller
{
	public $cols = [
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

        $x = [
        		'advertise_rate_type_id' => true,
        		'rate_name' => true,
        		'gross_rate' => true,
        		'discount' => true,
        		'nett_rate' => true,
        		'paper_id' => false
        		];

        /*$ser = serialize($x);
        $unser = unserialize($ser);
        dd($unser);*/

        return view('vendor.material.master.rate.list');
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
                            ->join('medias','medias.media_id','=','advertise_rates.media_id')
                            ->where('rates.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('advertise_rate_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('end_valid_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('nett_rate','like','%' . $searchPhrase . '%');
                            })
                            ->skip($skip)->take($rowCount)
                            ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = Rate::join('advertise_rate_types','advertise_rate_types.advertise_rate_type_id','=','rates.advertise_rate_type_id')
                            ->join('medias','medias.media_id','=','advertise_rates.media_id')
                            ->where('rates.active','1')
                            ->where(function($query) use($searchPhrase) {
                                $query->where('advertise_rate_type_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('rate_name','like','%' . $searchPhrase . '%')
                                        ->orWhere('end_valid_date','like','%' . $searchPhrase . '%')
                                        ->orWhere('nett_rate','like','%' . $searchPhrase . '%');
                            })->count();

        return response()->json($data);
    }
}
