<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Media;

class PosisiIklanController extends Controller
{
    public function index(Request $request)
    {
    	if(Gate::denies('Posisi Iklan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['medias'] = Media::where('active', '1')->orderBy('media_name', 'asc')->get();

        $thisyear = date('Y');
        $data['thisyear'] = $thisyear;
        $data['thismonth'] = date('m');
        $data['years'] = [$thisyear-2, $thisyear-1, $thisyear, $thisyear+1];
        $data['months'] = [
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

        return view('vendor.material.workorder.posisiiklan.index', $data);
    }
}
