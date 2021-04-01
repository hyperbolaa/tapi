<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 * @package App\Http\Controllers\Api
 * 权限gate映射
 * index	viewAny
 * show	    view
 * create	create
 * store	create
 * edit	    update
 * update	update
 * destroy	delete
 */
class UserController extends Controller
{
    const ITEM_PER_PAGE = 10;

    /**
     * 用户列表
     */
    public function index(Request $request){
        $limit   = $request->input('limit', static::ITEM_PER_PAGE);
        $type    = $request->input('type', '');
        $keyword = $request->input('keyword', '');

        $userQuery = User::query();
        if($type && $keyword){
            switch ($type){
                case 'email':
                    $userQuery->where('email', 'LIKE', '%' . $keyword . '%');
                    break;
                case 'name':
                    $userQuery->where('name', 'LIKE', '%' . $keyword . '%');
                    break;
            }
        }

        return UserResource::collection($userQuery->paginate($limit));
    }

    /**
     * 新建用户
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules(),
            $this->getMessages()
        );

        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors());
        } else {
            $user = User::create([
                'uuid'      => getUuid(),
                'email'     => $request->input('email'),
                'password'  => Hash::make($request->input('password')),
                'name'      => $request->input('name'),
                'role'      => $request->input('role'),
            ]);
            return jsonResponseSuc(new UserResource($user));
        }
    }


    /**
     * 展示用户
     */
    public function show($uuid)
    {
        if( empty($uuid) ){
            return jsonResponseErr('100000', '参数不能为空');
        }
        $user = User::where('uuid', $uuid)->first();
        $data = new UserResource($user);
        return jsonResponseSuc($data);
    }


    /**
     * 更新用户
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules(false),
            $this->getMessages()
        );

        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors());
        } else {
            $uuid  = $request->input('uuid');
            $email = $request->input('email');
            $pass = $request->input('password');
            $name = $request->input('name');
            $role = $request->input('role');
            $user = User::where('uuid', $uuid)->first();
            if(empty($user)){
                return jsonResponseErr('510001','用户不存在');
            }
            if($user->email == 'admin@cc.com'){
                return jsonResponseErr('520001','系统用户不支持修改');
            }
            //邮箱账号不变的情况
            if($user->email == $email){
                $user->password     = Hash::make($pass);
                $user->name         = $name;
                $user->role         = $role;
                $user->save();
                return jsonResponseSuc(new UserResource($user));
            }else{
                $found = User::where('email', $email)->first();
                if(empty($found)){
                    $user->email    = $email;
                    $user->password = Hash::make($pass);
                    $user->name     = $name;
                    $user->role     = $role;
                    $user->save();
                    return jsonResponseSuc(new UserResource($user));
                }else{
                    return jsonResponseErr('500001','邮箱账号已存在');
                }
            }
        }
    }


    /**
     * 删除用户
     */
    public function destroy(Request $request)
    {
        try {
            $uuid = $request->get('uuid');
            if(empty($uuid)){
                return jsonResponseErr('100001','参数错误');
            }
            $user = User::where(['uuid'=>$uuid])->first();
            if(empty($user)){
                return jsonResponseErr('500001','用户不存在');
            }
            if($user->email == 'admin@cc.com'){
                return jsonResponseErr('500001','系统用户不支持删除');
            }
            $status = $user->delete();
            if(!$status){
                return jsonResponseErr('500002','删除失败');
            }
        } catch (\Exception $ex) {
            return jsonResponseErr('510000',$ex->getMessage());
        }
        return jsonResponseSuc();
    }

    /**
     * 修改密码
     */
    public function password(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $rule = [
                'uuid'              => ['required'],
                'password'          => ['required', 'min:6', 'max:20'],
                'newPassword'       => ['required', 'min:6', 'max:20'],
                'confirmPassword'   => ['same:newPassword'],
            ]
        );
        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors()->first());
        }

        $uuid    = $request->input('uuid');
        $pwd_old = $request->input('password');
        $pwd_new = $request->input('newPassword');

        if($pwd_old == $pwd_new){
            return jsonResponseErr('100003', '新密码不能与旧密码相同');
        }
        $user = User::where('uuid',$uuid)->first();
        if(empty($user)){
            return jsonResponseErr('100002', '用户不存在');
        }

        if(!Hash::check($pwd_old, $user['password']) ){
            return jsonResponseErr('500003', '原密码错误');
        }
        $user->password = Hash::make($pwd_new);
        $user->save();

        return jsonResponseSuc();
    }

    /**
     * 区域搜索
     */
    public function search(Request $request){
        $name = $request->input('name');
        $query = User::query();
        if(!empty($name)){
            $query->where('name', 'LIKE', '%' . $name . '%');
        }
        $data = $query->get();
        $return = [];
        foreach ($data as $item){
            $return[] = ['name'=>$item['name'],'value'=>$item['uuid']];
        }
        return jsonResponseSuc($return);
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
                'email'     => ['required','email','unique:users'],
                'name'      => ['required'],
                'role'      => ['required'],
                'password'  => ['required', 'min:6', 'max:20'],
            ];
        }else{
            $rule = [
                'email'     => ['required','email'],
                'name'      => ['required'],
                'role'      => ['required'],
                'password'  => ['required', 'min:6', 'max:20'],
            ];
        }
        return $rule;
    }

    /**
     * 错误信息
     * @return array
     */
    private function getMessages()
    {
        return [
            'email.required'    => '邮箱需填写',
            'email.unique'      => '邮箱已存在',
            'email.email'       => '邮箱格式',
            'name.required'     => '用户名需填写',
            'role.required'     => '角色需填写',
            'password'          => '密码需填写,长度6~20位',
        ];
    }
}
