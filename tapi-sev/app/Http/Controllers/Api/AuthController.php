<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

/**
 * 登录
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{

    private $error_limit_count = 5;//同账号允许连续登录失败的次数
    private $error_limit_time  = 3600;//失败禁止登录时间限制，单位：秒

    /**
     * 登录
     */
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidationRules(),
            $this->getMessages()
        );
        if ($validator->fails()) {
            return jsonResponseErr('100001',$validator->errors());
        }
        //失败次数限制
        $cache_key = 'web_login_error_count_key_'.$request->input('username');
        $cache_val = Cache::get($cache_key,0);
        if($cache_val >= $this->error_limit_count){
            return jsonResponseErr('200002','账号已锁定，请1小时后再试');
        }

        $username = $request->input('username');
        $password = $request->input('password');
        if ($token = Auth()->attempt(['email'=>$username,'password'=>$password])) {
            Cache::forget($cache_key);//成功清除次数
            return jsonResponseSuc()->header('Authorization', $token);
        }
        //失败增加次数
        Cache::put($cache_key,$cache_val+1,$this->error_limit_time);
        return jsonResponseErr('500002','账号或密码错误.');
    }

    /**
     * 退出
     */
    public function logout()
    {
        Auth()->logout();
        return jsonResponseSuc();
    }

    /**
     * 用户信息
     */
    public function user()
    {
        return jsonResponseSuc(new UserResource(Auth::user()));
    }


    private function getValidationRules()
    {
        return [
            'username' => ['required','email','max:30'],
            'password' => ['required', 'min:6','max:20'],
        ];
    }


    private function getMessages()
    {
        return [
            'username.required'  => '请填写邮箱格式账号',
            'username.email'     => '请填写邮箱格式账号',
            'username.max'       => '请填写邮箱格式账号',
            'password.required'  => '请输入6-20位密码',
            'password.min'       => '请输入6-20位密码',
            'password.max'       => '请输入6-20位密码',
        ];
    }

}
