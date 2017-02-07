<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Project;
use App\ProjectTask;
use App\ProjectTaskType;
use DB;
use Gate;
use Mail;
use Log;

use Carbon\Carbon;

use App\Ibrol\Libraries\UserLibrary;

class ReportGridController extends Controller
{
    public function index() {
    	if(Gate::denies('Project Report (GRID)-Read')) {
            abort(403, 'Unauthorized action.');
        }

    	$data = array();

    	$data['project_task_types'] = ProjectTaskType::where('active', '1')->orderBy('project_task_type_name')->get();

    	return view('vendor.material.grid.report.index', $data);
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
				project_tasks.project_task_delivery_date
			FROM 
				project_tasks
			INNER JOIN projects ON projects.project_id = project_tasks.project_id
			INNER JOIN project_task_types ON project_task_types.project_task_type_id = project_tasks.project_task_type_id
			INNER JOIN users userpic ON userpic.user_id= project_tasks.pic
			INNER JOIN users userauthor ON userauthor.user_id= project_tasks.created_by
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

    	$q .= ' ORDER BY project_name ASC';

    	//dd($q);

    	$result = DB::select($q);

    	$data = array();

    	$data['result'] = $result;

    	return response()->json($data);
    }

    public function apiGenerateReportProposal(Request $request) {
        $period_start = $request->input('period_start');

        $q = "SELECT 
                grid_proposals.grid_proposal_id,
                grid_proposals.grid_proposal_name,
                grid_proposals.grid_proposal_deadline,
                CONCAT(userpic1.user_firstname, ' ', userpic1.user_lastname) AS pic_1_name,
                CONCAT(userpic2.user_firstname, ' ', userpic2.user_lastname) AS pic_2_name,
                CONCAT(userauthor.user_firstname, ' ', userauthor.user_lastname) AS author_name,
                grid_proposals.created_at,
                grid_proposals.grid_proposal_ready_date,
                grid_proposals.grid_proposal_delivery_date
            FROM 
                grid_proposals
            INNER JOIN users userpic1 ON userpic1.user_id= grid_proposals.pic_1
            INNER JOIN users userpic2 ON userpic2.user_id= grid_proposals.pic_2
            INNER JOIN users userauthor ON userauthor.user_id= grid_proposals.created_by
            WHERE
                grid_proposals.active = '1'";

        if($period_start != "") {
            $period_start = Carbon::createFromFormat('d/m/Y', $request->input('period_start'))->toDateString();
            $period_end = Carbon::createFromFormat('d/m/Y', $request->input('period_end'))->toDateString();

            $q .= " AND grid_proposals.grid_proposal_deadline BETWEEN '" . $period_start . "' AND '" . $period_end . "'";
        }

        $q .= ' ORDER BY grid_proposal_name ASC';

        //dd($q);

        $result = DB::select($q);

        $data = array();

        $data['result'] = $result;

        return response()->json($data);
    }

    public function apiGetTotalProposalPerMonth(Request $request) {
        if(Gate::denies('Grid Proposal-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $u = new UserLibrary;
        $subordinate = $u->getSubOrdinateArrayID($request->user()->user_id);
        $user_on_proposal = DB::select("SELECT created_by from grid_proposals group by created_by");
        $up = array();
        foreach ($user_on_proposal as $uop) {
            array_push($up, $uop->created_by);
        }
        $users = User::whereIn('user_id', $subordinate)->whereIn('user_id', $up)->get();

        $tgl = $this->generateStartEndDatePerYear(date('Y'));
        $total = array();
        $i = 0;
        foreach($users as $user) {
            $total[$i]['user_firstname'] = $user->user_firstname;
            $total[$i]['user_lastname'] = $user->user_lastname;
            $total[$i]['total'] = array();

            foreach ($tgl as $key => $value) {
                $start_date = $value['start_date'];
                $end_date = $value['end_date'];

                $q = DB::select("SELECT 
                                    count(grid_proposal_id) AS total
                                from 
                                    grid_proposals 
                                INNER JOIN users ON users.user_id = grid_proposals.created_by
                                WHERE 
                                    (
                                        grid_proposal_ready_date BETWEEN '" . $start_date . "' AND '" . $end_date . "'
                                    ) 
                                    AND grid_proposals.created_by = '" . $user->user_id . "'
                                    AND grid_proposals.flow_no = '98'
                                    AND grid_proposals.active = '1'");
                $total[$i]['total'][$key]['month_name'] = $value['month_name'];
                $total[$i]['total'][$key]['total'] = $q[0]->total;
            }

            $i++;
        }

        //untuk proposal (yg login)
        $total[$i]['user_firstname'] = $request->user()->user_firstname;
        $total[$i]['user_lastname'] = $request->user()->user_lastname;
        $total[$i]['total'] = array();
        foreach ($tgl as $key => $value) {
            $start_date = $value['start_date'];
            $end_date = $value['end_date'];

            $q = DB::select("SELECT 
                                count(grid_proposal_id) AS total
                                from 
                                    grid_proposals 
                            INNER JOIN users ON users.user_id = grid_proposals.created_by
                                WHERE 
                                    (
                                        grid_proposal_ready_date BETWEEN '" . $start_date . "' AND '" . $end_date . "'
                                    ) 
                                    AND grid_proposals.created_by = '" . $request->user()->user_id . "'
                                    AND grid_proposals.flow_no = '98'
                                    AND grid_proposals.active = '1'");
            $total[$i]['total'][$key]['month_name'] = $value['month_name'];
            $total[$i]['total'][$key]['total'] = $q[0]->total;
        }

        $i = $i+1;

        //untuk total proposal
        $total[$i]['user_firstname'] = 'Total';
        $total[$i]['user_lastname'] = 'Proposal';
        $total[$i]['total'] = array();
        foreach ($tgl as $key => $value) {
            $start_date = $value['start_date'];
            $end_date = $value['end_date'];

            $q = DB::select("SELECT 
                                count(grid_proposal_id) AS total
                                from 
                                    grid_proposals 
                            INNER JOIN users ON users.user_id = grid_proposals.created_by
                                WHERE 
                                    (
                                        grid_proposal_ready_date BETWEEN '" . $start_date . "' AND '" . $end_date . "'
                                    )
                                    AND grid_proposals.flow_no = '98'
                                    AND grid_proposals.active = '1'");
            $total[$i]['total'][$key]['month_name'] = $value['month_name'];
            $total[$i]['total'][$key]['total'] = $q[0]->total;
        }

        $data = $total;

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
