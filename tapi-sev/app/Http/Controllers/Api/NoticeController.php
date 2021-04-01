<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NoticeResource;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoticeController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 个人团队列表
     */
    public function index(Request $request){
        $limit = $request->input('limit', static::ITEM_PER_PAGE);
        $query = Notice::query();
        return NoticeResource::collection($query->paginate($limit));
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
            Notice::create([
                'uuid'  => Auth::user()->uuid,
                'name' => $request->input('name'),
                'content' => $request->input('content'),
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
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules()
        );

        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors());
        } else {
            $id   = $request->input('id');
            $name = $request->input('name');
            $content = $request->input('content');

            $res  = Notice::find($id);
            if(empty($res)){
                return jsonResponseErr('500001','信息不存在');
            }

            try {
                $res->uuid      = Auth::user()->uuid;
                $res->name      = $name;
                $res->content   = $content;
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
            $res = Notice::find($id);
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
            'name'  => ['required','max:100'],
            'content'  => ['required','max:200'],
        ];
    }
}
