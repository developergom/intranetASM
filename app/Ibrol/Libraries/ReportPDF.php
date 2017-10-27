<?php

namespace App\Ibrol\Libraries;

use PDF;
use App\User;

class ReportPDF{

	public function generateSalesPerformance($nik)
	{
		$filename = 'sales_performance_' . $nik . '_' . date('YmdHis');

		$data['user'] = User::where('user_name', $nik)->first();

		$pdf = PDF::loadView('vendor.material.libraries.sales_performance', $data);
        return $pdf->save($filename.'.pdf');
	}
	
}