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
use App\SummaryItem;
use App\Ibrol\Libraries\UserLibrary;

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

    private $userlibrary;

    public function __construct(){
        $this->thisyear = date('Y');
        $this->thismonth = date('m');
        $this->years = [$this->thisyear-2, $this->thisyear-1, $this->thisyear, $this->thisyear+1];

        $this->userlibrary = new UserLibrary;
    }

    public function index()
    {
    	if(Gate::denies('Posisi Iklan-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.workorder.posisiiklan.list', $data);
    }

    public function create(Request $request)
    {
        if(Gate::denies('Posisi Iklan-Create')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $data['medias'] = Media::where('active', '1')->whereIn('media_id', $this->userlibrary->getMedias($request->user()->user_id))->orderBy('media_name', 'asc')->get();

        $data['thisyear'] = $this->thisyear;
        $data['thismonth'] = $this->thismonth;
        $data['years'] = $this->years;
        $data['months'] = $this->months;

        return view('vendor.material.workorder.posisiiklan.create', $data);
    }

    public function store(Request $request)
    {

        $this->validate($request,
            [
                'media_id' => 'required',
                'view_type' => 'required',
                'posisi_iklan_code' => 'required|unique:posisi_iklan,posisi_iklan_code|max:50',
            ]
        );

        if($request->input('view_type')=='print') {
            $this->validate($request,
                [
                    'edition_date' => 'required'
                ]
            );

            $obj = new PosisiIklan;
            $obj->posisi_iklan_code = $request->input('posisi_iklan_code');
            $obj->media_id = $request->input('media_id');
            $obj->posisi_iklan_edition = Carbon::createFromFormat('d/m/Y', $request->input('edition_date'))->toDateString();
            $obj->posisi_iklan_type = 'print';
            $obj->posisi_iklan_notes = $request->input('posisi_iklan_notes');
            $obj->revision_no = 0;
            $obj->active = '1';
            $obj->created_by = $request->user()->user_id;
            $obj->save();

            $print_posisi_iklan_page_no = $request->input('print_posisi_iklan_page_no');
            $print_posisi_iklan_materi = $request->input('print_posisi_iklan_materi');
            $print_posisi_iklan_sales_order = $request->input('print_posisi_iklan_sales_order');
            $summary_item_id = $request->input('summary_item_id');
            $checkPrint = $request->input('checkPrint');

            $client_id = $request->input('client_id');
            $proposal_name = $request->input('proposal_name');
            $industry_id = $request->input('industry_id');
            $user_id = $request->input('user_id');

            $posisi_iklan_nett = $request->input('posisi_iklan_nett');
            $posisi_iklan_ppn = $request->input('posisi_iklan_ppn');
            $posisi_iklan_total = $request->input('posisi_iklan_total');

            foreach($print_posisi_iklan_page_no as $key => $value) {
                if(array_key_exists($key, $checkPrint)) {
                    $item = new PosisiIklanItem;
                    $item->posisi_iklan_id = $obj->posisi_iklan_id;
                    $item->summary_item_id = $summary_item_id[$key];
                    $item->client_id = $client_id[$key];
                    $item->posisi_iklan_item_name = $proposal_name[$key];
                    $item->industry_id = $industry_id[$key];
                    $item->sales_id = $user_id[$key];
                    $item->posisi_iklan_item_page_no = $print_posisi_iklan_page_no[$key];
                    $item->posisi_iklan_item_materi = $print_posisi_iklan_materi[$key];
                    $item->posisi_iklan_item_sales_order = $print_posisi_iklan_sales_order[$key];
                    $item->posisi_iklan_item_nett = $posisi_iklan_nett[$key];
                    $item->posisi_iklan_item_ppn = $posisi_iklan_ppn[$key];
                    $item->posisi_iklan_item_total = $posisi_iklan_total[$key];
                    $item->revision_no = 0;
                    $item->active = '1';
                    $item->created_by = $request->user()->user_id;
                    $item->save();

                    $summary_item = SummaryItem::find($summary_item_id[$key]);
                    $summary_item->summary_item_viewed = 'COMPLETED';
                    $summary_item->updated_by = $request->user()->user_id;
                    $summary_item->save();
                }
            }

            $request->session()->flash('status', 'Data has been saved!');
            
        }elseif($request->input('view_type')=='digital') {
            $this->validate($request,
                [
                    'month' => 'required',
                    'year' => 'required'
                ]
            );

            $obj = new PosisiIklan;
            $obj->posisi_iklan_code = $request->input('posisi_iklan_code');
            $obj->media_id = $request->input('media_id');
            $obj->posisi_iklan_month = $request->input('month');
            $obj->posisi_iklan_year = $request->input('year');
            $obj->posisi_iklan_type = 'digital';
            $obj->posisi_iklan_notes = $request->input('posisi_iklan_notes');
            $obj->revision_no = 0;
            $obj->active = '1';
            $obj->created_by = $request->user()->user_id;
            $obj->save();

            $digital_posisi_iklan_canal = $request->input('digital_posisi_iklan_canal');
            $digital_posisi_iklan_order_digital = $request->input('digital_posisi_iklan_order_digital');
            $digital_posisi_iklan_materi = $request->input('digital_posisi_iklan_materi');
            $digital_posisi_iklan_status_materi = $request->input('digital_posisi_iklan_status_materi');
            $digital_posisi_iklan_capture_materi = $request->input('digital_posisi_iklan_capture_materi');
            $digital_posisi_iklan_sales_order = $request->input('digital_posisi_iklan_sales_order');
            $summary_item_id = $request->input('summary_item_id');
            $checkDigital = $request->input('checkDigital');

            $client_id = $request->input('client_id');
            $proposal_name = $request->input('proposal_name');
            $industry_id = $request->input('industry_id');
            $user_id = $request->input('user_id');

            $posisi_iklan_nett = $request->input('posisi_iklan_nett');
            $posisi_iklan_ppn = $request->input('posisi_iklan_ppn');
            $posisi_iklan_total = $request->input('posisi_iklan_total');

            foreach($digital_posisi_iklan_canal as $key => $value) {
                if(array_key_exists($key, $checkDigital)) {

                    $item = new PosisiIklanItem;
                    $item->posisi_iklan_id = $obj->posisi_iklan_id;
                    $item->summary_item_id = $summary_item_id[$key];
                    $item->client_id = $client_id[$key];
                    $item->posisi_iklan_item_name = $proposal_name[$key];
                    $item->industry_id = $industry_id[$key];
                    $item->sales_id = $user_id[$key];
                    $item->posisi_iklan_item_canal = $digital_posisi_iklan_canal[$key];
                    $item->posisi_iklan_item_order_digital = $digital_posisi_iklan_order_digital[$key];
                    $item->posisi_iklan_item_materi = $digital_posisi_iklan_materi[$key];
                    $item->posisi_iklan_item_status_materi = $digital_posisi_iklan_status_materi[$key];
                    $item->posisi_iklan_item_capture_materi = $digital_posisi_iklan_capture_materi[$key];
                    $item->posisi_iklan_item_sales_order = $digital_posisi_iklan_sales_order[$key];
                    $item->posisi_iklan_item_nett = $posisi_iklan_nett[$key];
                    $item->posisi_iklan_item_ppn = $posisi_iklan_ppn[$key];
                    $item->posisi_iklan_item_total = $posisi_iklan_total[$key];
                    $item->revision_no = 0;
                    $item->active = '1';
                    $item->created_by = $request->user()->user_id;
                    $item->save();

                    $summary_item = SummaryItem::find($summary_item_id[$key]);
                    $summary_item->summary_item_viewed = 'COMPLETED';
                    $summary_item->updated_by = $request->user()->user_id;
                    $summary_item->save();
                }
            }

            $request->session()->flash('status', 'Data has been saved!');
        }

        return redirect('workorder/posisi_iklan');
    }

    public function show($id)
    {
        $data = array();

        $data['posisi_iklan'] = PosisiIklan::with('posisiiklanitems',
                                                    'media',
                                                    'posisiiklanitems.summaryitem',
                                                    'posisiiklanitems.client',
                                                    'posisiiklanitems.industry',
                                                    'posisiiklanitems.sales')
                                            ->find($id);

        dd($data);

        return view('vendor.material.workorder.posisiiklan.show', $data); 
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

    public function apiCheckCode(Request $request)
    {
        $media_id = $request->input('media_id');
        $view_type = $request->input('view_type');
        $month = $request->input('month');
        $year = $request->input('year');
        $edition_date = $request->input('edition_date');

        $data = [];

        $data['code'] = $this->generateCode($media_id, $view_type, $month, $year, $edition_date);

        $posisiiklan = PosisiIklan::where('posisi_iklan_code', $data['code'])->where('active', '1')->count();
        if($posisiiklan > 0) {
            $data['status'] = false;
        }else{
            $data['status'] = true;
        }

        return response()->json($data);
    }

    private function generateCode($media_id, $view_type, $month = '', $year = '', $edition_date = '')
    {
        $code = '';
        $media = Media::find($media_id);

        if($view_type=='print')
        {
            $ed = Carbon::createFromFormat('d/m/Y', $edition_date);

            $code = $media->media_code . '-P.' . $ed->format('Y') . $ed->format('m') . $ed->format('d');
        }elseif($view_type=='digital'){
            $code = $media->media_code . '-D.' . $year . $month;
        }else{
            $code = 'UNKNOWN';
        }

        return $code;
    }
}
