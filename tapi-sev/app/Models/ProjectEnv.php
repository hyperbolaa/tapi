<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEnv extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pid','name', 'domain','protocol'
    ];
}
