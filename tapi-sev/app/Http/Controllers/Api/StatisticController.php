<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatisticResource;
use App\Models\Statistic;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 动态
     */
    public function index(Request $request){
        $limit = $request->input('limit', static::ITEM_PER_PAGE);

        $query = Statistic::query();

        return StatisticResource::collection($query->paginate($limit));
    }
}
