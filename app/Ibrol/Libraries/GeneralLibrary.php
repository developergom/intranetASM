<?php

namespace App\Ibrol\Libraries;

use Carbon\Carbon;

class GeneralLibrary{
	public function getMonthDate($month, $year)
	{
		$result = array();

		$tmp = $year . '-' . $month . '-01 00:00:00';
		
		$date1 = Carbon::createFromFormat('Y-m-d H:i:s', $tmp);
		$date2 = Carbon::createFromFormat('Y-m-d H:i:s', $tmp)->endOfMonth();
		
		$result['start'] = $date1;
		$result['end'] = $date2;

		return $result;
	}
}