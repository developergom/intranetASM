<?php

namespace App\Ibrol\Libraries;

use Excel;
use App\Proposal;
use App\User;

class ReportXls{

	public function generateSalesPerformance($filename, $nik, $datestart, $dateend)
	{

		$data['user'] = User::where('user_name', $nik)->first();
		$data['proposals'] = Proposal::where(function($q) use ($data, $datestart, $dateend) {
                                                $q->where('created_by', $data['user']->user_id);
                                                })
                                            ->where('active', '1')
                                            ->whereBetween('created_at', [$datestart, $dateend])
                                            ->get();

		Excel::create($filename, function($excel) use($data){

		    // Set the title
		    $excel->setTitle('Sales Performance ' . $data['user']->user_firstname . ' ' . $data['user']->user_lastname);

		    // Chain the setters
		    $excel->setCreator('igom.gramedia-majalah.com')
		          ->setCompany('Kompas Gramedia');

		    $proposals = $data['proposals'];
		    $excel->sheet('Proposal', function($sheet) use($proposals){
		    	foreach ($proposals as $proposal) {
		    		$sheet->appendRow(array(
	                    $proposal->proposal_id, $proposal->proposal_name
	                ));	
		    	}
		    });

		})->store('xlsx');;

	}
	
}