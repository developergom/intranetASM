<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\Industry;
use App\Media;
use App\SellPeriod;
use App\User;
use DB;
use Gate;
use Mail;
use Log;

use Carbon\Carbon;

use App\Ibrol\Libraries\UserLibrary;

class ReportController extends Controller
{
    public function index()
    {

    }

    public function inventory() {
    	if(Gate::denies('Inventory Report-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

        $year = date('Y');

        $data['industries'] = Industry::where('active', '1')->orderBy('industry_name')->get();
    	$data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();
        $data['sellperiods'] = SellPeriod::where('active', '1')->orderBy('sell_period_month')->get();
        $data['years'] = [$year, $year-1, $year-2];

    	return view('vendor.material.report.inventory.index', $data);
    }

    public function proposal() {
        if(Gate::denies('Proposal Report (GRID)-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        return view('vendor.material.grid.report.proposal', $data);
    }

    public function apiGenerateReport(Request $request) {
    	$project_task_type_ids = $request->input('project_task_type_ids');
    	$period_start = $request->input('period_start');

    	$q = "SELECT 
                    project_tasks.project_task_id,
                    project_tasks.project_task_name,
                    project_task_types.project_task_type_name,
                    projects.project_name,
                    project_tasks.project_task_deadline,
                    CONCAT(userpic.user_firstname, ' ', userpic.user_lastname) AS pic_name,
                    CONCAT(userauthor.user_firstname, ' ', userauthor.user_lastname) AS author_name,
                    project_tasks.created_at,
                    project_tasks.project_task_ready_date,
                    project_tasks.project_task_delivery_date,
                    project_task_histories.project_task_history_text,
                    project_task_histories.created_at AS history_date,
                    CONCAT(userhistory.user_firstname, ' ', userhistory.user_lastname) AS history_author_name,
                    approval_types.approval_type_name
                FROM 
                    project_tasks
                INNER JOIN projects ON projects.project_id = project_tasks.project_id
                INNER JOIN project_task_types ON project_task_types.project_task_type_id = project_tasks.project_task_type_id
                INNER JOIN project_task_histories ON project_task_histories.project_task_id = project_tasks.project_task_id
                INNER JOIN users userpic ON userpic.user_id= project_tasks.pic
                INNER JOIN users userauthor ON userauthor.user_id= project_tasks.created_by
                INNER JOIN users userhistory ON userhistory.user_id= project_task_histories.created_by
                INNER JOIN approval_types ON approval_types.approval_type_id = project_task_histories.approval_type_id
                WHERE
                    project_tasks.active = '1'";

		if($project_task_type_ids != "") {
    		$q .= " AND project_tasks.project_task_type_id IN (" . implode(', ', array_map(null, $project_task_type_ids)) . ")";
    	}

    	if($period_start != "") {
    		$period_start = Carbon::createFromFormat('d/m/Y', $request->input('period_start'))->toDateString();
    		$period_end = Carbon::createFromFormat('d/m/Y', $request->input('period_end'))->toDateString();

    		$q .= " AND project_tasks.project_task_deadline BETWEEN '" . $period_start . "' AND '" . $period_end . "'";
    	}

    	$q .= ' ORDER BY project_name, project_task_histories.created_at ASC';

    	//dd($q);

    	$result = DB::select($q);

    	$data = array();

    	$data['result'] = $result;

    	return response()->json($data);
    }

    private function generateStartEndDatePerYear($year) {
        $tgl = array();
        for($i = 1; $i <= 12; $i++) {
            $start_date = $year . '-' . $i . '-01';
            $tanggal = Carbon::createFromFormat('Y-m-d', $start_date);
            $bulan = $tanggal->format('m');
            $start_date = $tanggal->toDateString();
            $end_date = $year . '-' . $bulan . '-' . $tanggal->daysInMonth;
            $tgl[$i]['start_date'] = $start_date;
            $tgl[$i]['end_date'] = $end_date;
            $tgl[$i]['month_name'] = $tanggal->format('F');
        }

        return $tgl;
    }
}
