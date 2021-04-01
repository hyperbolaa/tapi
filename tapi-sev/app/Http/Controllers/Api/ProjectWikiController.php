<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectWikiResource;
use App\Models\ProjectWiki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectWikiController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 个人团队列表
     */
    public function index(Request $request){
        $limit = $request->input('limit', static::ITEM_PER_PAGE);
        $pid   = $request->input('pid');

        if(empty($pid)){
            return jsonResponseErr('100000','参数错误，缺少团队ID');
        }

        $query = ProjectWiki::query();
        $query->where('pid',$pid);

        return ProjectWikiResource::collection($query->paginate($limit));
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
            ProjectWiki::create([
                'pid'     => $request->input('pid'),
                'editor'  => Auth::user()->uuid,
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
            $id      = $request->input('id');
            $content = $request->input('content');

            $res  = ProjectWiki::find($id);
            if(empty($res)){
                return jsonResponseErr('500001','信息不存在');
            }

            try {
                $res->editor  = Auth::user()->uuid;
                $res->content = $content;
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
            $res = ProjectWiki::find($id);
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
            'pid'       => ['required'],
            'content'   => ['required'],
        ];
    }
}
