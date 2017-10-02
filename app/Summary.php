<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    protected $table = 'summaries';
	protected $primaryKey = 'summary_id';

	protected $fillable = [
				'proposal_id', 
				'summary_order_no',
				'summary_sent_date',
				'summary_total_gross',
				'summary_total_disc',
				'summary_total_nett',
				'summary_total_po',
				'summary_total_internal_omzet',
				'top_type',
				'top_count',
				'revision_no',
				'current_user',
				'flow_no',
				'pic',
				'updated_at',
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by'
	];

	public function proposal()
	{
		return $this->belongsTo('App\Proposal', 'proposal_id');
	}

	public function summaryitems()
	{
		return $this->hasMany('App\SummaryItem', 'summary_id');
	}

	public function summaryhistories()
	{
		return $this->hasMany('App\SummaryHistory', 'summary_id');
	}

	public function uploadfiles()
	{
		return $this->belongsToMany('App\UploadFile', 'summary_upload_file');
	}

	public function getCreatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function getUpdatedByAttribute($value)
	{
		$user = User::find($value); 
		return $user;
	}

	public function _currentuser()
	{
		return $this->belongsTo('App\User', 'current_user');
	}

	public function _pic()
	{
		return $this->belongsTo('App\User', 'pic');
	}

	public function mutationitems()
	{
		return $this->hasMany('App\Mutation', 'mutation_item');
	}
}
