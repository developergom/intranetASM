<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowGroup extends Model
{
    protected $table = 'flow_groups';
	protected $primaryKey = 'flow_group_id';

	protected $fillable = [
				'module_id','flow_group_name', 'flow_group_desc', 'active'
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function module() {
		return $this->belongsTo('App\Module');
	}

	public function flows() {
		return $this->hasMany('App\Flow', 'flow_group_id');
	}
}
