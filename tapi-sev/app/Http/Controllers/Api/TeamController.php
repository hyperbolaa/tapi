<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{

    /**
     * 个人团队列表
     */
    public function index(Request $request){
        $name = $request->input('name');
        $uuid = Auth::user()->uuid;
        if(empty($uuid)){
            return jsonResponseErr('100000','登录状态失效，请重新登录');
        }

        $query = Team::query();
        $query->where('uuid',$uuid);
        if($name){
            $query->where('name','LIKE','%'.$name.'%');
        }

        return jsonResponseSuc($query->get());
    }

    /**
     * 新建用户
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
            Team::create([
                'uuid' => Auth::user()->uuid,
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
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
        $res = Team::find($id);
        if(empty($res)){
            return jsonResponseErr('100000','数据不存在');
        }
        $uuid = Auth::user()->uuid;
        $userRes = TeamMember::where(['tid'=>$id,'uuid'=>$uuid])->first();
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
            $res  = Team::find($id);
            if(empty($res)){
                return jsonResponseErr('500001','信息不存在');
            }

            if($res->name != $name){
                $found = Team::where('name', $name)->first();
                if(!empty($found)){
                    return jsonResponseErr('500001','已存在相同名称团队');
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
            $res = Team::find($id);
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
     * 规则,是用数组[] 或者 | 分隔符
     * @param bool $isNew
     * @return array
     */
    private function getValidationRules($isNew = true)
    {
        if($isNew){
            $rule = [
                'name'  => ['required','max:100'],
                'desc'  => ['max:200'],
            ];
        }else{
            $rule = [
                'name'  => ['required','max:100'],
                'desc'  => ['max:200'],
            ];
        }
        return $rule;
    }


}
