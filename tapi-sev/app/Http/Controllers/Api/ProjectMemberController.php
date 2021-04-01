<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectMemberResource;
use App\Models\ProjectMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectMemberController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 个人团队列表
     */
    public function index(Request $request){
        $limit = $request->input('limit', static::ITEM_PER_PAGE);
        $pid   = $request->input('pid');

        if(empty($pid)){
            return jsonResponseErr('100000','参数错误，缺少项目ID');
        }

        $query = ProjectMember::query()->with('user');
        $query->where('pid',$pid);

        return ProjectMemberResource::collection($query->paginate($limit));
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
            ProjectMember::create([
                'pid'  => $request->input('pid'),
                'uuid' => $request->input('uuid'),
                'role' => $request->input('role'),
            ]);
            return jsonResponseSuc();
        } catch (\Exception $ex) {
            return jsonResponseErr('600000',$ex->getMessage());
        }

    }

    /**
     * 更新用户
     */
    public function update(Request $request)
    {
        $id   = $request->input('id');
        $role = $request->input('role');

        if (empty($id) || empty($role)) {
            return jsonResponseErr('100001','参数错误');
        } else {
            $res  = ProjectMember::find($id);
            if(empty($res)){
                return jsonResponseErr('500001','信息不存在');
            }

            try {
                $res->role  = $role;
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
            $res = ProjectMember::find($id);
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
     * @return array
     */
    private function getValidationRules()
    {
        return [
            'pid'   => ['required'],
            'uuid'  => ['required'],
            'role'  => ['required'],
        ];
    }
}
