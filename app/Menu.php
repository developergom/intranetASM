<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menus';
	protected $primaryKey = 'menu_id';

	protected $fillable = [
				'module_id', 'menu_name', 'menu_desc', 'menu_icon', 'menu_order', 'menu_parent', 'active'
	];

	protected $hidden = [
				'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function module() {
        return $this->hasOne('App\Module','module_id','module_id');
    }
}
