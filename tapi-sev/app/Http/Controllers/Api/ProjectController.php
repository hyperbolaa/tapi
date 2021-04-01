<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Follow;
use App\Models\Project;
use App\Models\ProjectEnv;
use App\Models\ProjectMember;
use App\Models\ProjectTag;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 列表
     */
    public function index(Request $request){
        $limit   = $request->input('limit', static::ITEM_PER_PAGE);
        $tid     = $request->input('tid', 0);
        $keyword = $request->input('keyword', '');
        if(empty($tid)){
            return jsonResponseErr('100001','参数错误');
        }
        $query = Project::query();
        $query->where('tid', $tid);
        if($keyword){
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        }

        return ProjectResource::collection($query->paginate($limit));
    }


    /**
     * 添加
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules()
        );

        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors());
        }
        try {
            Project::create([
                'uuid'  => Auth::user()->uuid,
                'tid'   => $request->input('tid'),
                'name'  => $request->input('name'),
                'desc'  => $request->input('desc'),
                'path'  => $request->input('path'),
            ]);
            return jsonResponseSuc();
        } catch (\Exception $ex) {
            return jsonResponseErr('600000',$ex->getMessage());
        }
    }

    /**
     * 个人团队详情
     */
    public function detail(Request $request){
        $id = $request->input('id');
        if(empty($id)){
            return jsonResponseErr('100000','参数错误');
        }
        $res = Project::with(['cats','tags'])->find($id);
        if(empty($res)){
            return jsonResponseErr('100000','数据不存在');
        }
        $uuid = Auth::user()->uuid;
        $userRes = ProjectMember::where(['pid'=>$id,'uuid'=>$uuid])->first();
        $res['role'] = $userRes ? $userRes['role'] : 'dever';
        return jsonResponseSuc($res);
    }

    /**
     * 更新用户
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules(false)
        );

        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors());
        } else {
            $id = $request->input('id');
            $name = $request->input('name');
            $desc = $request->input('desc');
            $res  = Project::find($id);
            if(empty($res)){
                return jsonResponseErr('500001','信息不存在');
            }

            if($res->name != $name){
                $found = Project::where('name', $name)->first();
                if(!empty($found)){
                    return jsonResponseErr('500001','已存在相同名称项目');
                }
            }

            try {
                $res->name  = $name;
                $res->desc  = $desc;
                $res->save();
                return jsonResponseSuc();
            } catch (\Exception $ex) {
                return jsonResponseErr('600000',$ex->getMessage());
            }
        }
    }
    /**
     * 删除用户
     */
    public function destroy(Request $request)
    {
        try {
            $id = $request->get('id');
            if(empty($id)){
                return jsonResponseErr('100001','参数错误');
            }
            $res = Project::find($id);
            if(empty($res)){
                return jsonResponseErr('500001','数据不存在');
            }
            $status = $res->delete();
            if(!$status){
                return jsonResponseErr('500002','删除失败');
            }
        } catch (\Exception $ex) {
            return jsonResponseErr('510000',$ex->getMessage());
        }
        return jsonResponseSuc();
    }


    /**
     * 关注
     */
    public function follow(Request $request)
    {
        try {
            $id   = $request->get('id');
            $flag = $request->get('flag');
            $uuid = Auth::user()->uuid;
            if(empty($id) || !in_array($flag,['on','off'])){
                return jsonResponseErr('100001','参数错误');
            }
            $found = Project::find($id);
            if(empty($found)){
                return jsonResponseErr('500001','数据不存在');
            }
            if($flag == 'on'){
                $data = [
                    'pid'  => $id,
                    'uuid' => $uuid,
                ];
                Follow::create($data);
            }else{
                Follow::query()->where(['uuid'=>$uuid,'pid'=>$id])->delete();
            }
        } catch (\Exception $ex) {
            return jsonResponseErr('510000',$ex->getMessage());
        }
        return jsonResponseSuc();
    }

    /**
     * 规则,是用数组[] 或者 | 分隔符
     * @param bool $isNew
     * @return array
     */
    private function getValidationRules($isNew = true)
    {
        if($isNew){
            $rule = [
                'name' => ['required','max:100'],
                'tid'  => ['required','numeric'],
                'path' => ['max:50'],
                'desc' => ['max:200'],
            ];
        }else{
            $rule = [
                'name' => ['required','max:100'],
                'tid'  => ['required','numeric'],
                'path' => ['max:50'],
                'desc' => ['max:200'],
            ];
        }
        return $rule;
    }
}
