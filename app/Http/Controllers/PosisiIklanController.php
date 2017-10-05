<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Media;
use App\PosisiIklan;
use App\PosisiIklanItem;

class PosisiIklanController extends Controller
{
    private $thisyear, $thismonth, $years;
    private $months = [
                            [
                                'key' => '01',
                                'values' => 'January'
                            ],
                            [
                                'key' => '02',
                                'values' => 'February'
                            ],
                            [
                                'key' => '03',
                                'values' => 'March'
                            ],
                            [
                                'key' => '04',
                                'values' => 'April'
                            ],
                            [
                                'key' => '05',
                                'values' => 'May'
                            ],
                            [
                                'key' => '06',
                                'values' => 'June'
                            ],
                            [
                                'key' => '07',
                                'values' => 'July'
                            ],
                            [
                                'key' => '08',
                                'values' => 'August'
                            ],
                            [
                                'key' => '09',
                                'values' => 'September'
                            ],
                            [
                                'key' => '10',
                                'values' => 'October'
                            ],
                            [
                                'key' => '11',
                                'values' => 'November'
                            ],
                            [
                                'key' => '12',
                                'values' => 'December'
                            ]
                        ];

    public function __construct(){
        $this->thisyear = date('Y');
        $this->thismonth = date('m');
        $this->years = [$this->thisyear-2, $this->thisyear-1, $this->thisyear, $this->thisyear+1];
    }

    public function index()
    {
    	if(Gate::denies('Posisi Iklan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.workorder.posisiiklan.list', $data);
    }

    public function create()
    {
        if(Gate::denies('Posisi Iklan-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['medias'] = Media::where('active', '1')->orderBy('media_name', 'asc')->get();

        $data['thisyear'] = $this->thisyear;
        $data['thismonth'] = $this->thismonth;
        $data['years'] = $this->years;
        $data['months'] = $this->months;

        return view('vendor.material.workorder.posisiiklan.create', $data);
    }

    public function apiList(Request $request)
    {
        $current = $request->input('current') or 1;
        $rowCount = $request->input('rowCount') or 5;
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
        $data['rows'] = PosisiIklan::select('posisi_iklan.*', 'media_name')
                                    ->join('medias', 'medias.media_id', '=', 'posisi_iklan.media_id')
                                    ->where('posisi_iklan.active','1')
                                    ->where(function($query) use($searchPhrase) {
                                        $query->where('posisi_iklan_code','like','%' . $searchPhrase . '%')
                                                ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                                ->orWhere('posisi_iklan_type','like','%' . $searchPhrase . '%');
                                    })
                                    ->skip($skip)->take($rowCount)
                                    ->orderBy($sort_column, $sort_type)->get();
        $data['total'] = PosisiIklan::select('posisi_iklan.*', 'media_name')
                                    ->join('medias', 'medias.media_id', '=', 'posisi_iklan.media_id')
                                    ->where('posisi_iklan.active','1')
                                    ->where(function($query) use($searchPhrase) {
                                        $query->where('posisi_iklan_code','like','%' . $searchPhrase . '%')
                                                ->orWhere('media_name','like','%' . $searchPhrase . '%')
                                                ->orWhere('posisi_iklan_type','like','%' . $searchPhrase . '%');
                                    })->count();

        return response()->json($data);
    }
}
