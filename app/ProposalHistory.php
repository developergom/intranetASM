<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProposalHistory extends Model
{
    protected $table = 'proposal_histories';
	protected $primaryKey = 'proposal_history_id';

	protected $fillable = [
				'proposal_id', 
				'approval_type_id', 
				'proposal_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function proposal() 
	{
		return $this->belongsTo('App\Proposal', 'proposal_id');
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
