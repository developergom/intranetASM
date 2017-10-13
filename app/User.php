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
        'updated_by',
        'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
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

    public function mediagroups() {
        return $this->belongsToMany('App\MediaGroup','users_media_groups');
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
        return $this->belongsToMany('App\Agenda', 'agendas_users');
    }

    public function activities() {
        return $this->belongsToMany('App\Activity', 'activities_users');
    }

    public function projecttasktypes()
    {
        return $this->hasMany('App\ProjectTaskType', 'user_id');
    }

    public function gridprojectcurrentuser()
    {
        return $this->hasMany('App\Project', 'current_user');
    }

    public function gridprojectpic()
    {
        return $this->hasMany('App\Project', 'pic');
    }

    public function gridprojecttaskcurrentuser()
    {
        return $this->hasMany('App\ProjectTask', 'current_user');
    }

    public function gridprojecttaskpic()
    {
        return $this->hasMany('App\ProjectTask', 'pic');
    }

    public function gridproposalcurrentuser()
    {
        return $this->hasMany('App\GridProposal', 'current_user');
    }

    public function gridproposalapproval1()
    {
        return $this->hasMany('App\GridProposal', 'approval_1');
    }

    public function gridproposalpic1()
    {
        return $this->hasMany('App\GridProposal', 'pic_1');
    }

    public function gridproposalpic2()
    {
        return $this->hasMany('App\GridProposal', 'pic_2');
    }

    public function gridproposalcreatedby()
    {
        return $this->hasMany('App\GridProposal', 'created_by');
    }

    public function proposalcurrentuser()
    {
        return $this->hasMany('App\Proposal', 'current_user');
    }

    public function proposalpic()
    {
        return $this->hasMany('App\Proposal', 'pic');
    }

    public function summarycurrentuser()
    {
        return $this->hasMany('App\Summary', 'current_user');
    }

    public function summarypic()
    {
        return $this->hasMany('App\Summary', 'pic');
    }

    public function mutationto()
    {
        return $this->hasMany('App\Mutation', 'mutation_to');
    }

    public function mutationfrom()
    {
        return $this->hasMany('App\Mutation', 'mutation_from');
    }

    public function salesposisiiklanitems()
    {
        return $this->hasMany('App\PosisiIklanItem', 'sales_id', 'user_id');
    }

    public function picposisiiklanitemtasks()
    {
        return $this->hasMany('App\PosisiIklanItemTask', 'posisi_iklan_item_task_pic', 'user_id');
    }

    public function salessummaryitems()
    {
        return $this->hasMany('App\SummaryItem', 'sales_id', 'user_id');
    }
}
