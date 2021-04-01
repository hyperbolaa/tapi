<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ColCat;
use App\Services\ApiServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ColCatController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 列表
     */
    public function index(Request $request){
        $pid     = $request->input('pid', 0);
        if(empty($pid)){
            return jsonResponseErr('100001','参数错误');
        }
        $query = ColCat::query()->with('apis');
        $query->where('pid', $pid);

        $res = ApiServer::buildApiMenu($query->get());
        return jsonResponseSuc($res);
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
            ColCat::create([
                'uuid' => Auth::user()->uuid,
                'pid'  => $request->input('pid'),
                'name' => $request->input('name'),
                'desc' => $request->input('desc'),
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
        }
        $id   = $request->input('id');
        $name = $request->input('name');
        $desc = $request->input('desc');

        $res  = ColCat::find($id);
        if(empty($res)){
            return jsonResponseErr('500001','信息不存在');
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
            $res = ColCat::find($id);
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
