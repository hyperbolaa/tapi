<?php


namespace App\Services;


use App\Models\Follow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class FollowServer
{
    /**
     * 获取个人的关注项目
     */
    public static function getByUuid($uuid){
        $key   = 'follow_project_'.$uuid;
        $cache = Cache::get($key);
        if(!empty($cache)){
            return unserialize($cache);
        }
        $res = Follow::where('uuid',$uuid)->get();
        if($res->isNotEmpty()){
            $data = $res->toArray();
            Cache::put($key,serialize($data),100);//单位秒
            return $data;
        }
        return [];
    }

    /**
     * 是否关注项目
     */
    public static function isFolow($pid){
        $uuid = Auth::user()->uuid;
        $res = Follow::where(['uuid'=>$uuid,'pid'=>$pid])->first();
        if(empty($res)){
            return 'off';
        }
        return 'on';
    }
}
