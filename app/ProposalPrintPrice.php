<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalPrintPrice extends Model
{
    protected $table = 'proposal_print_prices';
	protected $primaryKey = 'proposal_print_price_id';

	protected $fillable = [
				'proposal_id', 
				'price_type_id', 
				'media_id',
				'media_edition_id',
				'advertise_rate_id',
				'proposal_print_price_startdate',
				'proposal_print_price_enddate',
				'proposal_print_price_deadline',
				'proposal_print_price_remarks',
				'proposal_print_price_gross_rate',
				'proposal_print_price_surcharge',
				'proposal_print_price_total_gross_rate',
				'proposal_print_price_discount',
				'proposal_print_price_nett_rate',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function proposal()
	{
		return $this->belongsTo('App\InventoryPlanner', 'proposal_id');
	}

	public function pricetype()
	{
		return $this->belongsTo('App\PriceType', 'price_type_id');
	}

	public function media()
	{
		return $this->belongsTo('App\Media', 'media_id');
	}

	public function mediaedition()
	{
		return $this->belongsTo('App\MediaEdition', 'media_edition_id');
	}

	public function advertiserate()
	{
		return $this->belongsTo('App\AdvertiseRate', 'advertise_rate_id');
	}
}
