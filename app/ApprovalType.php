<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalType extends Model
{
    protected $table = 'approval_types';
	protected $primaryKey = 'approval_type_id';

	protected $fillable = [
				'approval_type_name'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function actionplanhistories() {
		return $this->hasMany('App\ActionPlanHistory', 'approval_type_id');
	}
}
