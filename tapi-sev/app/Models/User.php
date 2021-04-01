<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','name', 'email', 'password','role','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];



    /**
     * 新增jwt实现
     * @return mixed
     * @author yuchong
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * 新增jwt实现
     * @return array
     * @author yuchong
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 本地作用域
     * 只查询 超级管理员 用户的作用域
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'adminer');
    }

}
