<?php
use Carbon\Carbon;

if (! function_exists('jsonResponseErr')) {
    /**
     * json 返回格式化--失败
     * @param string $code  错误码
     * @param string $msg   错误信息
     * @param array $data   返回数据
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonResponseErr($code='100001',$msg='unknown error',$data=[])
    {
        return response()->json(['code'=>$code,'msg'=>$msg,'data'=>$data]);
    }
}

if (! function_exists('jsonResponseSuc')) {
    /**
     * json 返回格式化--成功
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonResponseSuc($data=[])
    {
        return response()->json(['code'=>'000000','msg'=>'success','data'=>$data]);
    }
}

if (! function_exists('formatDate')) {

    /**
     * 时间格式化
     */
    function formatDate($time,$format='Y-m-d')
    {
        if($time){
            return date($format,strtotime($time));
        }
        return $time;
    }
}


if (! function_exists('getDateRange')) {
    /**
     * 时间区间
     * @return array
     */
    function getDateRange($key=''){
        $data = [];
        #今天
        $data['today']     = [Carbon::today()->format('Y-m-d'), Carbon::tomorrow()->format('Y-m-d')];
        #昨天
        $data['yesterday'] = [Carbon::yesterday()->format('Y-m-d'), Carbon::today()->format('Y-m-d')];
        // 本周
        $data['curr_week'] = [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')];
        // 上周
        $data['last_week'] = [Carbon::now()->startOfWeek()->subWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->subWeek()->format('Y-m-d')];
        // 本月
        $data['curr_month'] = [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')];
        // 上月
        $data['last_month'] = [Carbon::now()->startOfMonth()->subMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->subMonth()->format('Y-m-d')];
        // 本年
        $data['curr_year'] = [Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')];
        // 本年
        $data['last_year'] = [Carbon::now()->startOfYear()->subYear()->format('Y-m-d'), Carbon::now()->endOfYear()->subYear()->format('Y-m-d')];
        return $key ? $data[$key] : $data;
    }
}


if (! function_exists('getUuid')) {
    /**
     * 获取用户唯一id
     */
    function getUuid(){
        $uuid = Illuminate\Support\Str::uuid();
        return str_replace('-','',$uuid);
    }
}


if (! function_exists('map_role')) {
    /**
     * 系统角色
     */
    function map_role($key){
        $role_arr = ['adminer'=>'管理员','customer'=>'开发人员'];
        return $role_arr[$key] ?? '未设置角色';
    }
}

if (! function_exists('map_team_role')) {
    /**
     * 团队角色
     */
    function map_team_role($key){
        $role_arr = ['leader'=>'组长','dever'=>'开发者'];
        return $role_arr[$key] ?? '开发者';
    }
}

if (! function_exists('map_project_role')) {
    /**
     * 项目角色
     */
    function map_project_role($key){
        $role_arr = ['leader'=>'组长','dever'=>'开发者'];
        return $role_arr[$key] ?? '开发者';
    }
}

if (! function_exists('map_notice_status')) {
    /**
     * 系统通知
     */
    function map_notice_status($key){
        $role_arr = [0=>'待发送',1=>'已发送'];
        return $role_arr[$key] ?? '待发送';
    }
}
if (! function_exists('recursion_res')) {
    /**
     * 返回参数递归,构造vue-tree数据类型
     */
    function recursion_res($data,$fid=0){
        $return = [];
        if(is_array($data) && !empty($data)){
            foreach ($data as $key => $item) {
                if($item['fid'] == $fid){
                    $return[$key] = $item;
                    $children = recursion_res($data,$item['id']);
                    if(!empty($children)){
                        $return[$key]['children'] = collect($children)->values();
                        unset($children);
                    }
                }
            }
        }
        return collect($return)->sortBy('id')->values();
    }
}

if (! function_exists('recursion_json')) {
    /**
     * 返回参数递归--构造json串
     */
    function recursion_json($data){
        $return = [];
        if(!empty($data)){
            foreach ($data as $key => $item) {
                $return[$item['name']] = $item['value'];
                if($item['children']->isNotEmpty()){
                    $return[$item['name']] = recursion_json($item['children']);
                }
            }
        }
        return $return;
    }
}

