<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgendaType extends Model
{
    protected $table = 'agenda_types';
	protected $primaryKey = 'agenda_type_id';

	protected $fillable = [
				'agenda_type_name', 'agenda_type_desc'
	];

	protected $hidden = [
				'active', 'created_by', 'created_at', 'updated_by', 'updated_at'
	];

	public function agendas() {
		return $this->hasMany('App\Agenda', 'agenda_type_id');
	}
}
