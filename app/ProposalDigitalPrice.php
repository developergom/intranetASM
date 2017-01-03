<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalDigitalPrice extends Model
{
    protected $table = 'proposal_digital_prices';
	protected $primaryKey = 'proposal_digital_price_id';

	protected $fillable = [
				'proposal_id', 
				'price_type_id', 
				'media_id',
				'advertise_rate_id',
				'proposal_digital_price_startdate',
				'proposal_digital_price_enddate',
				'proposal_digital_price_deadline',
				'proposal_digital_price_remarks',
				'proposal_digital_price_gross_rate',
				'proposal_digital_price_surcharge',
				'proposal_digital_price_total_gross_rate',
				'proposal_digital_price_discount',
				'proposal_digital_price_nett_rate',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function proposal()
	{
		return $this->belongsTo('App\Proposal', 'proposal_id');
	}

	public function pricetype()
	{
		return $this->belongsTo('App\PriceType', 'price_type_id');
	}

	public function media()
	{
		return $this->belongsTo('App\Media', 'media_id');
	}

	public function advertiserate()
	{
		return $this->belongsTo('App\AdvertiseRate', 'advertise_rate_id');
	}
}
