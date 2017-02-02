<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GridProposalHistory extends Model
{
    protected $table = 'grid_proposal_histories';
	protected $primaryKey = 'grid_proposal_history_id';

	protected $fillable = [
				'grid_proposal_id', 
				'approval_type_id', 
				'grid_proposal_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function gridproposal()
	{
		return $this->belongsTo('App\GridProposal', 'grid_proposal_id');
	}

	public function approvaltype()
	{
		return $this->belongsTo('App\ApprovalType', 'approval_type_id');	
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
}
