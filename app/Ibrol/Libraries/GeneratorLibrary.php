<?php

namespace App\Ibrol\Libraries;

use App\Media;
use App\Proposal;
use App\Summary;

class GeneratorLibrary{
	public function proposal_no($proposal_id) {
		//AUT.033980/IKL/IX/17

		$proposal = Proposal::find($proposal_id);

		$code = 'PROP';
		if($proposal->medias()->count() > 1) {
			$code = 'G';
		}elseif($proposal->medias()->count() == 1){
			$media = $proposal->medias()->first();
			$code = $media->media_code;
		}else{
			$code = 'UNDEFINED';
		}

		$no = '000001';
		switch ($proposal_id) {
			case $proposal_id >= 100000:
				$no = $proposal_id;
				break;

			case $proposal_id >= 10000:
				$no = '0' . $proposal_id;
				break;
			
			case $proposal_id >= 1000:
				$no = '00' . $proposal_id;
				break;

			case $proposal_id >= 100:
				$no = '000' . $proposal_id;
				break;

			case $proposal_id >= 10:
				$no = '0000' . $proposal_id;
				break;

			default:
				$no = '00000' . $proposal_id;
				break;
		}

		$proposal_no = $code . '.' . $no . '/IKL/' . $this->getMonthCode(date('n')) . '/' . date('y');

		return $proposal_no;
	}

	public function summary_order_no($summary_id) {
		//AUT.033980/IKL/IX/17

		$summary = Summary::with('proposal','proposal.medias')->find($summary_id);

		$code = 'SUM';
		if($summary->proposal->medias()->count() > 1) {
			$code = 'G';
		}elseif($summary->proposal->medias()->count() == 1){
			$media = $summary->proposal->medias()->first();
			$code = $media->media_code;
		}else{
			$code = 'UNDEFINED';
		}

		$no = '000001';
		switch ($summary_id) {
			case $summary_id >= 100000:
				$no = $summary_id;
				break;

			case $summary_id >= 10000:
				$no = '0' . $summary_id;
				break;
			
			case $summary_id >= 1000:
				$no = '00' . $summary_id;
				break;

			case $summary_id >= 100:
				$no = '000' . $summary_id;
				break;

			case $summary_id >= 10:
				$no = '0000' . $summary_id;
				break;

			default:
				$no = '00000' . $summary_id;
				break;
		}

		$summary_order_no = 'SUM.' . $code . '.' . $no . '/IKL/' . $this->getMonthCode(date('n')) . '/' . date('y');

		return $summary_order_no;
	}

	public function getMonthCode($month) {
		$code = '';

		switch ($month) {
			case ($month == 1):
				$code = 'I';
				break;
			
			case ($month == 2):
				$code = 'II';
				break;

			case ($month == 3):
				$code = 'III';
				break;

			case ($month == 4):
				$code = 'IV';
				break;

			case ($month == 5):
				$code = 'V';
				break;

			case ($month == 6):
				$code = 'VI';
				break;

			case ($month == 7):
				$code = 'VII';
				break;

			case ($month == 8):
				$code = 'VIII';
				break;

			case ($month == 9):
				$code = 'IX';
				break;

			case ($month == 10):
				$code = 'X';
				break;

			case ($month == 11):
				$code = 'XI';
				break;

			case ($month == 12):
				$code = 'XII';
				break;

			default:
				$code = 'XX';
				break;
		}

		return $code;
	}
}