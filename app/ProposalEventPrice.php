<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalEventPrice extends Model
{
    protected $table = 'proposal_event_prices';
	protected $primaryKey = 'proposal_event_price_id';

	protected $fillable = [
				'proposal_id', 
				'price_type_id', 
				'media_id',
				'proposal_event_price_remarks',
				'proposal_event_price_gross_rate',
				'proposal_event_price_surcharge',
				'proposal_event_price_total_gross_rate',
				'proposal_event_price_discount',
				'proposal_event_price_nett_rate',
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
}
