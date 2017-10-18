<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractHistory extends Model
{
    protected $table = 'contract_histories';
	protected $primaryKey = 'contract_history_id';

	protected $fillable = [
				'contract_id', 
				'approval_type_id', 
				'contract_history_text'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function contract() 
	{
		return $this->belongsTo('App\Contract', 'contract_id');
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
