<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiResBody extends Model
{

    protected $table = 'api_res_bodys';
    /**
     * 不可批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];
}
