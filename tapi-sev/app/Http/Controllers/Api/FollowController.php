<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FollowResource;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 关注
     */
    public function index(Request $request){
        $limit = $request->input('limit', static::ITEM_PER_PAGE);
        $uuid = Auth::user()->uuid;

        $query = Follow::query();
        $query->where('uuid',$uuid);

        return FollowResource::collection($query->paginate($limit));
    }
}
