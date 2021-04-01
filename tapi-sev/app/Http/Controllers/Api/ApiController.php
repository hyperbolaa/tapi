<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Api;
use App\Services\ApiServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    const ITEM_PER_PAGE = 10;
    /**
     * 列表
     */
    public function index(Request $request){
        $limit  = $request->input('limit', static::ITEM_PER_PAGE);
        $pid    = $request->input('pid');
        $cid    = $request->input('cid');
        $name   = $request->input('name');
        $tag    = $request->input('tag');
        $status = $request->input('status');
        if(empty($pid)){
            return jsonResponseErr('100000','参数错误，缺少项目ID');
        }
        $query  = Api::query();
        if($cid){
            $query->where('cat_id',$cid);
        }
        if($name){
            $query->where('name','LIKE','%'.$name.'%');
        }
        if($tag){
            $query->where('tag_id',$tag);
        }
        if($status){
            $query->where('status',$status);
        }
        return ApiResource::collection($query->paginate($limit));

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
            $res = Api::create([
                'pid'    => $request->input('pid'),
                'cat_id' => $request->input('cat_id'),
                'name'   => $request->input('name'),
                'method' => $request->input('method','GET'),
                'path'   => $request->input('path'),
                'creater'=> Auth::user()->uuid,
                'updater'=> Auth::user()->uuid,
            ]);
            return jsonResponseSuc($res);
        } catch (\Exception $ex) {
            return jsonResponseErr('600000',$ex->getMessage());
        }

    }

    /**
     * 详情
     */
    public function detail(Request $request){
        $id = $request->input('id');
        if(empty($id)){
            return jsonResponseErr('100000','参数错误');
        }
        $res = Api::with(['pj','cat','tag','user','reqParam','reqQuery','reqHeader','reqBodyForm','reqBodyJson','resBody'])->find($id);
        if(empty($res)){
            return jsonResponseErr('100000','数据不存在');
        }
        $data = $res->toArray();

        if(!empty($data['req_param'])){//path
            $data['req_param'] = collect($data['req_param'])->sortBy('id')->values();
        }
        if(!empty($data['req_query'])){//query
            $data['req_query'] = collect($data['req_query'])->sortBy('id')->values();
        }
        if(!empty($data['req_header'])){//header
            $data['req_header'] = collect($data['req_header'])->sortBy('id')->values();
        }
        if(!empty($data['req_body_form'])){//body_form
            $data['req_body_form'] = collect($data['req_body_form'])->sortBy('id')->values();
        }
        if(!empty($data['req_body_json'])){//body_json构造递归
            $data['req_body_json'] = recursion_res($data['req_body_json']);
            $json_string = recursion_json($data['req_body_json']->toArray());
            if(!empty($json_string)){
                $data['req_body_json_string'] = json_encode($json_string);
            }else{
                $data['req_body_json_string'] = '';
            }
        }
        if(!empty($data['res_body'])){//res_body构造递归
            $data['res_body'] = recursion_res($data['res_body']);
        }
        return jsonResponseSuc($data);
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
        }

        // 完整数据结构
        $id     = $request->input('id');
        $pid    = $request->input('pid');
        $cat_id = $request->input('cat_id');
        $tag_id = $request->input('tag_id');
        $method = $request->input('method');
        $name   = $request->input('name');
        $path   = $request->input('path');
        $status = $request->input('status');
        $desc   = $request->input('desc');
        $req_body_type = $request->input('req_body_type','none');
        $req_params = $request->input('req_param');
        $req_query = $request->input('req_query');
        $req_header = $request->input('req_header');
        $req_body_form = $request->input('req_body_form');
        $req_body_json = $request->input('req_body_json');
        $res_body = $request->input('res_body');

        $res  = Api::find($id);
        if(empty($res)){
            return jsonResponseErr('500001','信息不存在');
        }

        if($res->path != $path){
            $found = Api::where(['pid'=>$pid,'path'=>$path])->first();
            if(!empty($found)){
                return jsonResponseErr('500001','已存在接口路径');
            }
        }

        try {
            $res->name    = $name;
            $res->cat_id  = $cat_id;
            $res->tag_id  = $tag_id;
            $res->method  = $method;
            $res->path    = $path;
            $res->status  = $status;
            $res->desc    = $desc;
            $res->updater = Auth::user()->uuid;
            $res->req_body_type = $req_body_type;
            $res->save();

            ApiServer::updateReqParam($id,$req_params);
            ApiServer::updateReqQuery($id,$req_query);
            ApiServer::updateReqHeader($id,$req_header);
            ApiServer::updateReqBody($id,$req_body_type,$req_body_form,$req_body_json);
            ApiServer::updateResBody($id,$res_body);

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
            $res = Api::find($id);
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
     * 修改分类
     */
    public function cat(Request $request)
    {
        try {
            $id     = $request->get('id');
            $cat_id = $request->get('cat_id');
            $uuid   = Auth::user()->uuid;

            $found = Api::find($id);
            if(empty($found)){
                return jsonResponseErr('500001','数据不存在');
            }
            $found->cat_id = $cat_id;
            $found->updater= $uuid;
            $found->save();

        } catch (\Exception $ex) {
            return jsonResponseErr('510000',$ex->getMessage());
        }
        return jsonResponseSuc();
    }

    /**
     * 修改状态
     */
    public function status(Request $request)
    {
        try {
            $id     = $request->get('id');
            $status = $request->get('status');
            $uuid   = Auth::user()->uuid;

            $found = Api::find($id);
            if(empty($found)){
                return jsonResponseErr('500001','数据不存在');
            }
            $found->status = $status;
            $found->updater= $uuid;
            $found->save();

        } catch (\Exception $ex) {
            return jsonResponseErr('510000',$ex->getMessage());
        }
        return jsonResponseSuc();
    }

    /**
     * 修改标签
     */
    public function tag(Request $request)
    {
        try {
            $id     = $request->get('id');
            $tag_id = $request->get('tag_id');
            $uuid   = Auth::user()->uuid;

            $found = Api::find($id);
            if(empty($found)){
                return jsonResponseErr('500001','数据不存在');
            }
            $found->tag_id = $tag_id;
            $found->updater= $uuid;
            $found->save();

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
                'pid'       => ['required','numeric'],
                'cat_id'    => ['required','numeric'],
                'name'      => ['required','max:100'],
                'path'      => ['max:200'],
            ];
        }else{
            $rule = [
                'name'  => ['required','max:100'],
                'path'  => ['max:200'],
            ];
        }
        return $rule;
    }
}
