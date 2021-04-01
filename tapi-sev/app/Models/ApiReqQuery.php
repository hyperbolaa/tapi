<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiReqQuery extends Model
{

    protected $table = 'api_req_querys';
    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
}
