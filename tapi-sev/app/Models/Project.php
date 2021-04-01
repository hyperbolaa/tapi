<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','tid', 'name', 'desc', 'path'
    ];

    /**
     * 获取用户
     */
    public function members()
    {
        return $this->hasMany('App\Models\ProjectMember','pid','id');
    }

    /**
     * 获取环境
     */
    public function envs()
    {
        return $this->hasMany('App\Models\ProjectEnv','pid','id');
    }

    /**
     * 获取标签
     */
    public function tags()
    {
        return $this->hasMany('App\Models\ProjectTag','pid','id');
    }

    /**
     * 获取标签
     */
    public function cats()
    {
        return $this->hasMany('App\Models\ApiCat','pid','id');
    }

}
