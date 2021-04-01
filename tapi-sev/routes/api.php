<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//接口路由--RouteServiceProvider
Route::group(['prefix' => 'api', 'namespace' => 'Api',], function () {
    Route::post('auth/login', 'AuthController@login');//用户登录
    //token认证: 必须登录
    Route::group(['middleware' => 'auth:api'], function () {
        //基础路由
        Route::get('auth/user', 'AuthController@user');//用户基本信息
        Route::post('auth/logout', 'AuthController@logout');//用户退出
        Route::post('user/password', 'UserController@password');//修改密码
        Route::get('dashboard/notice', 'DashboardController@notice');//个人首页
        Route::get('dashboard/follow', 'DashboardController@follow');//个人首页
        Route::get('dashboard/team', 'DashboardController@team');//个人首页

        //团队
        Route::post('teams/detail', 'TeamController@detail');
        Route::get('teams', 'TeamController@index');
        Route::post('teams', 'TeamController@store');
        Route::put('teams', 'TeamController@update');
        Route::delete('teams', 'TeamController@destroy');
        //团队成员
        Route::get('team/members', 'TeamMemberController@index');
        Route::post('team/members', 'TeamMemberController@store');
        Route::put('team/members', 'TeamMemberController@update');
        Route::delete('team/members', 'TeamMemberController@destroy');
        //动态
        Route::get('trends', 'TrendController@index');
        //关注
        Route::get('follows', 'FollowController@index');
        Route::post('follows', 'FollowController@store');
        Route::delete('follows', 'FollowController@destroy');
        //项目
        Route::get('projects', 'ProjectController@index');
        Route::post('projects', 'ProjectController@store');
        Route::put('projects', 'ProjectController@update');
        Route::delete('projects', 'ProjectController@destroy');
        Route::post('projects/detail', 'ProjectController@detail');
        Route::post('projects/follow', 'ProjectController@follow');
        //项目成员
        Route::get('project/members', 'ProjectMemberController@index');
        Route::post('project/members', 'ProjectMemberController@store');
        Route::put('project/members', 'ProjectMemberController@update');
        Route::delete('project/members', 'ProjectMemberController@destroy');
        //项目标签
        Route::get('project/tags', 'ProjectTagController@index');
        Route::post('project/tags', 'ProjectTagController@store');
        Route::put('project/tags', 'ProjectTagController@update');
        Route::delete('project/tags', 'ProjectTagController@destroy');
        //项目标签
        Route::get('project/envs', 'ProjectEnvController@index');
        Route::post('project/envs', 'ProjectEnvController@store');
        Route::put('project/envs', 'ProjectEnvController@update');
        Route::delete('project/envs', 'ProjectEnvController@destroy');
        //项目文档
        Route::get('project/wiki', 'ProjectWikiController@index');
        Route::post('project/wiki', 'ProjectWikiController@store');
        Route::put('project/wiki', 'ProjectWikiController@update');
        //接口
        Route::get('apis', 'ApiController@index');
        Route::post('apis', 'ApiController@store');
        Route::put('apis', 'ApiController@update');
        Route::delete('apis', 'ApiController@destroy');
        Route::put('apis/cat', 'ApiController@cat');
        Route::put('apis/status', 'ApiController@status');
        Route::put('apis/tag', 'ApiController@tag');
        Route::post('apis/detail', 'ApiController@detail');
        //接口分类
        Route::get('api/cats', 'ApiCatController@index');
        Route::get('api/cats/menu', 'ApiCatController@menu');
        Route::post('api/cats', 'ApiCatController@store');
        Route::put('api/cats', 'ApiCatController@update');
        Route::delete('api/cats', 'ApiCatController@destroy');
        //接口请求头
        Route::get('api/requests', 'ApiRequestController@index');
        Route::post('api/requests', 'ApiRequestController@store');
        Route::put('api/requests', 'ApiRequestController@update');
        Route::delete('api/requests', 'ApiRequestController@destroy');
        //接口响应头
        Route::get('api/responses', 'ApiResponseController@index');
        Route::post('api/responses', 'ApiResponseController@store');
        Route::put('api/responses', 'ApiResponseController@update');
        Route::delete('api/responses', 'ApiResponseController@destroy');


        //案例
        Route::get('cols', 'ColController@index');
        Route::post('cols', 'ColController@store');
        Route::put('cols', 'ColController@update');
        Route::delete('cols', 'ColController@destroy');
        //案例分类
        Route::get('col/cats', 'ColCatController@index');
        Route::post('col/cats', 'ColCatController@store');
        Route::put('col/cats', 'ColCatController@update');
        Route::delete('col/cats', 'ColCatController@destroy');
        //案例规则
        Route::get('col/rules', 'ColRuleController@index');
        Route::post('col/rules', 'ColRuleController@store');
        Route::put('col/rules', 'ColRuleController@update');
        Route::delete('col/rules', 'ColRuleController@destroy');

        //权限验证：管理员权限
        Route::group(['middleware' => 'can:gate-admin'], function () {
            //用户管理
            Route::get('users', 'UserController@index');
            Route::post('users', 'UserController@store');
            Route::put('users', 'UserController@update');
            Route::delete('users', 'UserController@destroy');
            Route::post('users/search', 'UserController@search');
            //通知管理
            Route::get('notices', 'NoticeController@index');
            Route::post('notices', 'NoticeController@store');
            Route::put('notices', 'NoticeController@update');
            Route::delete('notices', 'NoticeController@destroy');
            //统计管理
            Route::get('statics', 'StatisticController@index');
        });

    });
});
