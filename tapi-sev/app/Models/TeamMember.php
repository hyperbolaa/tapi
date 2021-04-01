<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tid','uuid', 'role'
    ];

    /**
     * 获取用户
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','uuid','uuid');
    }
}
