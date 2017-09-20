<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SummaryHistory extends Model
{
    protected $table = 'summary_histories';
	protected $primaryKey = 'summary_history_id';

	protected $fillable = [
				'summary_id', 
				'approval_type_id', 
				'summary_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function summary() 
	{
		return $this->belongsTo('App\Summary', 'summary_id');
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
