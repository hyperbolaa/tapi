<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiCat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','pid', 'name', 'desc'
    ];


    /**
     * 获取博客文章的评论
     */
    public function apis()
    {
        return $this->hasMany('App\Models\Api','cat_id');
    }


}
