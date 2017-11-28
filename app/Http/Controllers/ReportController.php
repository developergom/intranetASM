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
        if(Gate::denies('Proposal Report-Read')) {
            abort(403, 'Unauthorized action.');
        }

        $data = array();

        $year = date('Y');

        $data['industries'] = Industry::where('active', '1')->orderBy('industry_name')->get();
        $data['medias'] = Media::where('active', '1')->orderBy('media_name')->get();

        return view('vendor.material.report.proposal.index', $data);
    }

    public function apiGenerateInventoryReport(Request $request) {
        $media_ids = $request->input('media_ids');
        $industry_ids = $request->input('industry_ids');
        $sell_period_months = $request->input('sell_period_months');
    	$sell_period_years = $request->input('sell_period_years');
        $offer_period_start = $request->input('offer_period_start');
    	$offer_period_end = $request->input('offer_period_end');

    	$q = "SELECT 
                    a.inventory_planner_id,
                    b.inventory_source_name, 
                    a.inventory_planner_title,
                    a.inventory_planner_desc,
                    (
                        SELECT 
                            GROUP_CONCAT(sell_periods.sell_period_month_name, ' ', inventory_planner_sell_period.year SEPARATOR ', ') AS sell_month
                        FROM 
                            sell_periods 
                        JOIN inventory_planner_sell_period ON sell_periods.sell_period_id = inventory_planner_sell_period.sell_period_id
                        WHERE inventory_planner_sell_period.inventory_planner_id = a.inventory_planner_id
                    ) AS inventory_planner_sell_period,
                    (
                        SELECT 
                            GROUP_CONCAT(media_name SEPARATOR ', ') AS inventory_planner_media_name
                        FROM 
                            medias 
                        JOIN inventory_planner_media ON medias.media_id = inventory_planner_media.media_id
                        WHERE inventory_planner_media.inventory_planner_id = a.inventory_planner_id
                    ) AS inventory_planner_media_name,
                    a.inventory_planner_cost,
                    a.inventory_planner_media_cost_print,
                    a.inventory_planner_media_cost_other,
                    a.inventory_planner_total_offering,
                    industry_name,
                    brand_name,
                    f.proposal_id,
                    f.proposal_no,
                    proposal_status_name,
                    proposal_deal_cost,
                    proposal_deal_media_cost_print,
                    proposal_deal_media_cost_other,
                    proposal_total_deal,
                    proposal_ready_date
                FROM 
                    inventories_planner a
                LEFT JOIN inventory_sources b ON b.inventory_source_id = a.inventory_source_id
                LEFT JOIN inventory_planner_sell_period c ON c.inventory_planner_id = a.inventory_planner_id
                LEFT JOIN sell_periods d ON d.sell_period_id = c.sell_period_id
                RIGHT JOIN proposal_inventory_planner e ON e.inventory_planner_id = a.inventory_planner_id
                RIGHT JOIN proposals f ON f.proposal_id = e.proposal_id
                LEFT JOIN proposal_industry g ON g.proposal_id = f.proposal_id
                LEFT JOIN industries h ON h.industry_id = g.industry_id
                LEFT JOIN brands i ON i.brand_id = f.brand_id
                LEFT JOIN proposal_status j ON j.proposal_status_id = f.proposal_status_id
                LEFT JOIN inventory_planner_media k ON k.inventory_planner_id = a.inventory_planner_id
                LEFT JOIN medias l ON l.media_id = k.media_id
                WHERE
                    a.active = '1' AND
                    f.active = '1'";

		if($media_ids != "") {
    		$q .= " AND l.media_id IN (" . implode(', ', array_map(null, $media_ids)) . ")";
    	}

        if($industry_ids != "") {
            $q .= " AND h.industry_id IN (" . implode(', ', array_map(null, $industry_ids)) . ")";
        }

        if($sell_period_months != "") {
            $q .= " AND d.sell_period_id IN (" . implode(', ', array_map(null, $sell_period_months)) . ")";
        }

        if($sell_period_years != "") {
            $q .= " AND c.year IN (" . implode(', ', array_map(null, $sell_period_years)) . ")";
        }

    	if($offer_period_start != "") {
    		$offer_period_start = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_start'))->toDateString();
    		$offer_period_end = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_end'))->toDateString();

    		$q .= " AND f.proposal_ready_date BETWEEN '" . $offer_period_start . "' AND '" . $offer_period_end . "'";
    	}

    	$q .= ' GROUP BY f.proposal_id ORDER BY inventory_source_name, inventory_planner_title ASC';

    	$result = DB::select($q);

        //counting target
        $t = "SELECT SUM(target_amount) AS total_target FROM targets WHERE active = '1'";

        if($media_ids != "") {
            $t .= " AND media_id IN (" . implode(', ', array_map(null, $media_ids)) . ")";
        }

        if($industry_ids != "") {
            $t .= " AND industry_id IN (" . implode(', ', array_map(null, $industry_ids)) . ")";
        }

        if($offer_period_start != "") {
            $target_start = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_start'));
            $target_end = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_end'));

            $month = array();
            array_push($month, $target_start->format('m'));
            if($target_start->format('m')!=$target_end->format('m'))
                array_push($month, $target_end->format('m'));

            $year = array();
            array_push($year, $target_start->format('Y'));
            if($target_start->format('Y')!=$target_end->format('Y'))
                array_push($year, $target_end->format('Y'));

            $t .= " AND target_year IN (" . implode(', ', array_map(null, $year)) . ")";
            $t .= " AND target_month IN (" . implode(', ', array_map(null, $month)) . ")";
        }

        $target = DB::select($t);

    	$data = array();

        $data['result'] = $result;
    	$data['target'] = $target;

    	return response()->json($data);
    }

    public function apiGenerateProposalReport(Request $request) {
        $media_ids = $request->input('media_ids');
        $industry_ids = $request->input('industry_ids');
        $offer_period_start = $request->input('offer_period_start');
        $offer_period_end = $request->input('offer_period_end');

        $q = "SELECT 
                    a.proposal_id,
                    a.proposal_name,
                    a.proposal_cost,
                    a.proposal_media_cost_print,
                    a.proposal_media_cost_other,
                    a.proposal_total_offering,
                    a.proposal_no,
                    (
                        select 
                            GROUP_CONCAT(media_name SEPARATOR ', ') AS proposal_media_name
                        FROM 
                            medias 
                        JOIN proposal_media ON medias.media_id = proposal_media.media_id
                        WHERE proposal_media.proposal_id = a.proposal_id
                    ) AS proposal_media_name,
                    industry_name,
                    brand_name,
                    proposal_status_name,
                    proposal_deal_cost,
                    proposal_deal_media_cost_print,
                    proposal_deal_media_cost_other,
                    proposal_total_deal,
                    proposal_ready_date
                FROM 
                    proposals a
                LEFT JOIN proposal_industry b ON b.proposal_id = a.proposal_id
                LEFT JOIN industries c ON c.industry_id = b.industry_id
                LEFT JOIN brands d ON d.brand_id = a.brand_id
                LEFT JOIN proposal_status e ON e.proposal_status_id = a.proposal_status_id
                LEFT JOIN proposal_media f ON f.proposal_id = a.proposal_id
                LEFT JOIN medias g ON g.media_id = f.media_id
                WHERE
                    a.active = '1'";

        if($media_ids != "") {
            $q .= " AND g.media_id IN (" . implode(', ', array_map(null, $media_ids)) . ")";
        }

        if($industry_ids != "") {
            $q .= " AND c.industry_id IN (" . implode(', ', array_map(null, $industry_ids)) . ")";
        }

        if($offer_period_start != "") {
            $offer_period_start = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_start'))->toDateString();
            $offer_period_end = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_end'))->toDateString();

            $q .= " AND a.proposal_ready_date BETWEEN '" . $offer_period_start . "' AND '" . $offer_period_end . "'";
        }

        $q .= ' GROUP BY a.proposal_id ORDER BY proposal_name ASC';

        $result = DB::select($q);

        //counting target
        $t = "SELECT SUM(target_amount) AS total_target FROM targets WHERE active = '1'";

        if($media_ids != "") {
            $t .= " AND media_id IN (" . implode(', ', array_map(null, $media_ids)) . ")";
        }

        if($industry_ids != "") {
            $t .= " AND industry_id IN (" . implode(', ', array_map(null, $industry_ids)) . ")";
        }

        if($offer_period_start != "") {
            $target_start = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_start'));
            $target_end = Carbon::createFromFormat('d/m/Y', $request->input('offer_period_end'));

            $month = array();
            array_push($month, $target_start->format('m'));
            if($target_start->format('m')!=$target_end->format('m'))
                array_push($month, $target_end->format('m'));

            $year = array();
            array_push($year, $target_start->format('Y'));
            if($target_start->format('Y')!=$target_end->format('Y'))
                array_push($year, $target_end->format('Y'));

            $t .= " AND target_year IN (" . implode(', ', array_map(null, $year)) . ")";
            $t .= " AND target_month IN (" . implode(', ', array_map(null, $month)) . ")";
        }

        $target = DB::select($t);

        $data = array();

        $data['result'] = $result;
        $data['target'] = $target;

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
