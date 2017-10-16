<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

use Gate;
use App\Http\Requests;
use App\Media;
use App\SummaryItem;
use App\Ibrol\Libraries\UserLibrary;

class CheckingPositionController extends Controller
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

    private $userlibrary;

    public function __construct(){
        $this->thisyear = date('Y');
        $this->thismonth = date('m');
        $this->years = [$this->thisyear-2, $this->thisyear-1, $this->thisyear, $this->thisyear+1];

        $this->userlibrary = new UserLibrary;
    }

    public function index(Request $request)
    {
        if(Gate::denies('Checking Position-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['medias'] = Media::where('active', '1')->whereIn('media_id', $this->userlibrary->getMedias($request->user()->user_id))->orderBy('media_name', 'asc')->get();

        $data['thisyear'] = $this->thisyear;
        $data['thismonth'] = $this->thismonth;
        $data['years'] = $this->years;
        $data['months'] = $this->months;

        return view('vendor.material.posisiiklan.checkingposition.index', $data);
    }

    public function apiLocking(Request $request)
    {
    	if(Gate::denies('Checking Position-Update')) {
            return response()->json(200); //failed
        }

        $id = $request->input('summary_item_id');

        $obj = SummaryItem::find($id);

        $obj->summary_item_viewed = 'COMPLETED';
        $obj->updated_by = $request->user()->user_id;

        if($obj->save())
        {
            return response()->json(100); //success
        }else{
            return response()->json(200); //failed
        }
    }
}
