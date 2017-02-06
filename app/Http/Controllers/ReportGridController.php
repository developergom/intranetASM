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
}
