<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalOtherPrice extends Model
{
    protected $table = 'proposal_other_prices';
	protected $primaryKey = 'proposal_other_price_id';

	protected $fillable = [
				'proposal_id', 
				'price_type_id', 
				'media_id',
				'proposal_other_price_remarks',
				'proposal_other_price_gross_rate',
				'proposal_other_price_surcharge',
				'proposal_other_price_total_gross_rate',
				'proposal_other_price_discount',
				'proposal_other_price_nett_rate',
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
