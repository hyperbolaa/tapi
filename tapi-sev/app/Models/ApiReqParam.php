<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiReqParam extends Model
{
    protected $table = 'api_req_params';
    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
}
