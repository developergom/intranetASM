<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class Test extends Controller{
	public function __construct() {

	}

	public function index() {
		$date = '06/09/1990';
		$date = '';

		$date = Carbon::parse($date);
        echo $date;
	}
}