<?php

namespace App;

use Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 
        'user_email', 
        'user_firstname',
        'user_lastname',
        'user_phone',
        'user_gender',
        'religion_id',
        'user_birthdate',
        'user_lastlogin',
        'user_lastip',
        'user_avatar',
        'user_status',
        'active',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'user_id';

    public function roles() {
        return $this->belongsToMany('App\Role','users_roles');
    }

    public function groups() {
        return $this->belongsToMany('App\Group','users_groups');
    }

    public function medias() {
        return $this->belongsToMany('App\Media','users_medias');
    }

    public function religion() {
        return $this->belongsTo('App\Religion', 'religion_id');
    }

    public function hasRole($role_name) {
        foreach($this->roles as $role) {
            if($role->role_name == $role_name) {
                return true;
            }
        }
    }

    public function agendas() {
        return $this->belongsToMany('App\Agenda', 'agendas_clients');
    }
}
