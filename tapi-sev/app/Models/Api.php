<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];


    /**
     *项目
     */
    public function pj()
    {
        return $this->belongsTo('App\Models\Project','pid','id');
    }


    /**
     *分类
     */
    public function cat()
    {
        return $this->belongsTo('App\Models\ApiCat','cat_id','id');
    }

    /**
     *标签
     */
    public function tag()
    {
        return $this->belongsTo('App\Models\ProjectTag','tag_id','id');
    }

    /**
     * 用户信息
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User','updater','uuid');
    }

    /**
     *请求path
     */
    public function reqParam()
    {
        return $this->hasMany('App\Models\ApiReqParam','aid','id');
    }

    /**
     *请求query
     */
    public function reqQuery()
    {
        return $this->hasMany('App\Models\ApiReqQuery','aid','id');
    }

    /**
     *请求头信息
     */
    public function reqHeader()
    {
        return $this->hasMany('App\Models\ApiReqHeader','aid','id');
    }

    /**
     *请求头信息
     */
    public function reqBodyForm()
    {
        return $this->hasMany('App\Models\ApiReqBodyForm','aid','id');
    }

    /**
     *请求头信息
     */
    public function reqBodyJson()
    {
        return $this->hasMany('App\Models\ApiReqBodyJson','aid','id');
    }

    /**
     * 响应信息
     */
    public function resBody()
    {
        return $this->hasMany('App\Models\ApiResBody','aid','id');
    }
}
