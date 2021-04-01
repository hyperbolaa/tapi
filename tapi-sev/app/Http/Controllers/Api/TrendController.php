<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TrendResource;
use App\Models\Trend;
use Illuminate\Http\Request;

class TrendController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 动态
     */
    public function index(Request $request){
        $limit = $request->input('limit', static::ITEM_PER_PAGE);
        $type  = $request->input('type');

        if(empty($type)){
            return jsonResponseErr('100000','参数错误，缺少团队ID');
        }

        $query = Trend::query();

        return TrendResource::collection($query->paginate($limit));
    }


}
