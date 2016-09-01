<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $table = 'modules';
	protected $primaryKey = 'module_id';

	protected $fillable = [
				'module_url', 'module_desc', 'active'
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function actions() {
        return $this->belongsToMany('App\Action','actions_modules');
    }

    public function menu() {
    	return $this->belongsTo('App\Module','module_id','module_id');
    }

    public function flowgroup() {
    	return $this->hasOne('App\FlowGroup');
    }
}
