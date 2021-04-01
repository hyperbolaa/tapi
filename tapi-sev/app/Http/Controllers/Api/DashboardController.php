<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TeamResource;
use App\Models\Follow;
use App\Models\Notice;
use App\Models\Project;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * 系统消息
     */
    public function notice(){
        $res = Notice::query()->where('status',1)->orderByDesc('id')->limit(10)->get();
        return NoticeResource::collection($res);
    }

    /**
     * 个人关注
     */
    public function follow(){
        $uuid     = Auth::user()->uuid;
        $follows  = Follow::query()->select(['pid'])->where('uuid',$uuid)->orderByDesc('id')->limit(10)->get();
        $id_arr   = collect($follows)->pluck('pid')->toArray();
        $projects = Project::query()->whereIn('id',$id_arr)->orderByDesc('id')->get();
        return ProjectResource::collection($projects);
    }

    /**
     * 个人团队
     */
    public function team(){
        $uuid    = Auth::user()->uuid;
        $members = TeamMember::query()->select(['tid'])->where('uuid',$uuid)->orderByDesc('id')->limit(10)->get();
        $id_arr  = collect($members)->pluck('tid')->toArray();
        $teams   = Team::query()->whereIn('id',$id_arr)->orderByDesc('id')->get();
        return TeamResource::collection($teams);
    }

}
