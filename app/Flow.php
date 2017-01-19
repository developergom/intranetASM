<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flow extends Model
{
    protected $table = 'flows';
	protected $primaryKey = 'flow_id';

	protected $fillable = [
				'flow_group_id','flow_name', 'flow_url', 'flow_no', 'flow_prev', 'flow_next', 'role_id', 'flow_by', 'flow_parallel', 'flow_condition', 'flow_condition_value', 'active'
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public $flowbyitems = [
				'AUTHOR' => 'Author',
				'INDUSTRY' => 'Industry',
				'MEDIA' => 'Media',
				'PIC' => 'PIC',
				'GROUP' => 'Group',
				'MANUAL' => 'Manual'
	];

	public function flowgroup() {
		return $this->belongsTo('App\FlowGroup','flow_group_id');
	}

	public function role() {
		return $this->belongsTo('App\Role','role_id');
	}
}
