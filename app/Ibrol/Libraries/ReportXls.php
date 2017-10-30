<?php

namespace App\Ibrol\Libraries;

use Excel;
use Carbon\Carbon;

use App\Agenda;
use App\Contract;
use App\Proposal;
use App\Summary;
use App\User;

use App\Ibrol\Libraries\GeneralLibrary;

class ReportXls{

	public function generateSalesPerformance($filename, $nik, $datestart, $dateend)
	{
		$data = array();

		$data['formattedDateStart'] = Carbon::createFromFormat('Y-m-d H:i:s', $datestart)->format('d/m/Y');
		$data['formattedDateEnd'] = Carbon::createFromFormat('Y-m-d H:i:s', $dateend)->format('d/m/Y');

		$data['user'] = User::where('user_name', $nik)->first();

		$data['agendas'] = Agenda::select('agendas.agenda_id', 'agenda_type_name', 'agenda_date', 'agenda_destination', 'agenda_is_report', 'client_name')
											->join('agenda_types', 'agenda_types.agenda_type_id', '=', 'agendas.agenda_type_id')
											->join('agendas_clients', 'agendas_clients.agenda_id', '=', 'agendas.agenda_id')
											->join('clients', 'clients.client_id', '=', 'agendas_clients.client_id')
											->where('agendas.created_by', $data['user']->user_id)
                                            ->where('agendas.active', '1')
                                            ->whereBetween('agendas.created_at', [$datestart, $dateend])
                                            ->orderBy('agendas.agenda_date', 'asc')
                                            ->get();

		$data['proposals'] = Proposal::select('proposals.proposal_id', 'proposal_no', 'proposal_name', 'brand_name', 'proposal_status_name', 'proposal_method_name', 'proposals.created_at')
											->join('brands', 'brands.brand_id', '=', 'proposals.brand_id')
											->join('proposal_status', 'proposal_status.proposal_status_id', '=', 'proposals.proposal_status_id')
											->join('proposal_methods', 'proposal_methods.proposal_method_id', '=', 'proposals.proposal_method_id')
											->where('proposals.created_by', $data['user']->user_id)
                                            ->where('proposals.active', '1')
                                            ->whereBetween('proposals.created_at', [$datestart, $dateend])
                                            ->orderBy('proposals.created_at', 'asc')
                                            ->get();

        $data['contracts'] = Contract::select('contracts.contract_id', 'contract_no', 'proposal_name', 'proposal_no', 'brand_name', 'contracts.created_at')
        									->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
        									->join('brands', 'brands.brand_id', '=', 'proposals.brand_id')
        									->where('contracts.created_by', $data['user']->user_id)
                                            ->where('contracts.active', '1')
                                            ->whereBetween('contracts.created_at', [$datestart, $dateend])
                                            ->orderBy('contracts.created_at', 'asc')
                                            ->get();

        $data['summaries'] = Summary::select('summaries.summary_id', 'summary_order_no', 'contract_no', 'proposal_name', 'proposal_no', 'brand_name', 'summary_total_nett', 'top_type', 'summaries.created_at')
        									->join('contracts', 'contracts.contract_id', '=', 'summaries.contract_id')
        									->join('proposals', 'proposals.proposal_id', '=', 'contracts.proposal_id')
        									->join('brands', 'brands.brand_id', '=', 'proposals.brand_id')
        									->where('summaries.created_by', $data['user']->user_id)
                                            ->where('summaries.active', '1')
                                            ->whereBetween('summaries.created_at', [$datestart, $dateend])
                                            ->orderBy('summaries.created_at', 'asc')
                                            ->get();

		Excel::create($filename, function($excel) use($data){

		    // Set the title
		    $excel->setTitle('Sales Performance ' . $data['user']->user_firstname . ' ' . $data['user']->user_lastname . ' - Period ' . $data['formattedDateStart'] . ' to ' . $data['formattedDateEnd']);

		    // Chain the setters
		    $excel->setCreator('igom.gramedia-majalah.com')
		          ->setCompany('Kompas Gramedia');

		    $agendas = $data['agendas'];
		    $excel->sheet('Agenda', function($sheet) use($agendas){
		    	$sheet->appendRow(array(
		    						'Agenda Date',
		    						'Type',
		    						'Client',
		    						'Status',
		    						'Created At'
		    	));

		    	foreach ($agendas as $agenda) {
		    		$sheet->appendRow(array(
	                    $agenda->agenda_date,
	                    $agenda->agenda_type_name,
	                    $agenda->client_name,
	                    (($agenda->agenda_is_report=='1') ? 'REPORTED' : 'UNCOMPLETED'),
	                    $agenda->created_at
	                ));	
		    	}
		    });

		    $proposals = $data['proposals'];
		    $excel->sheet('Proposal', function($sheet) use($proposals){
		    	$sheet->appendRow(array(
		    						'Proposal Title',
		    						'Proposal No',
		    						'Brand',
		    						'Method',
		    						'Status',
		    						'Created At'
		    	));

		    	foreach ($proposals as $proposal) {
		    		$sheet->appendRow(array(
	                    $proposal->proposal_name,
	                    $proposal->proposal_no,
	                    $proposal->brand_name,
	                    $proposal->proposal_method_name,
	                    $proposal->proposal_status_name,
	                    $proposal->created_at
	                ));	
		    	}
		    });


		    $contracts = $data['contracts'];
		    $excel->sheet('Contract', function($sheet) use($contracts){
		    	$sheet->appendRow(array(
		    						'Contract No',
		    						'Proposal No',
		    						'Proposal Name',
		    						'Brand',
		    						'Created At'
		    	));

		    	foreach ($contracts as $contract) {
		    		$sheet->appendRow(array(
	                    $contract->contract_no,
	                    $contract->proposal_no,
	                    $contract->proposal_name,
	                    $contract->brand_name,
	                    $contract->created_at
	                ));	
		    	}
		    });


		    $summaries = $data['summaries'];
		    $excel->sheet('Summary', function($sheet) use($summaries){
		    	$sheet->appendRow(array(
		    						'Order No',
		    						'Contract No',
		    						'Proposal No',
		    						'Proposal Name',
		    						'Brand',
		    						'Term of Payment',
		    						'Total Nett',
		    						'Created At'
		    	));

		    	foreach ($summaries as $summary) {
		    		$sheet->appendRow(array(
	                    $summary->summary_order_no,
	                    $summary->contract_no,
	                    $summary->proposal_no,
	                    $summary->proposal_name,
	                    $summary->brand_name,
	                    $summary->top_type,
	                    $summary->summary_total_nett,
	                    $summary->created_at
	                ));	
		    	}
		    });

		})->store('xlsx');;

	}
	
}