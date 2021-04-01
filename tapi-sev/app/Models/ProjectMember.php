<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pid','uuid', 'role'
    ];

    /**
     * 用户信息
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','uuid','uuid');
    }
}
