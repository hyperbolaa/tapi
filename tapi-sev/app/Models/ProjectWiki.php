<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectWiki extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pid','editor', 'content'
    ];
}
