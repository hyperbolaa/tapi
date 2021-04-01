<?php


namespace App\Services;


use App\Models\ApiReqBodyForm;
use App\Models\ApiReqBodyJson;
use App\Models\ApiReqHeader;
use App\Models\ApiReqParam;
use App\Models\ApiReqQuery;
use App\Models\ApiResBody;
use Carbon\Carbon;

class ApiServer
{
    /**
     * api栏目
     */
    public static function buildApiMenu($data){
        $return = [];
        foreach ($data as $k=>$item){
            if(!empty($item['apis'])){
                foreach ($item['apis'] as $j=>$api){
                    $apis[$j] = [
                        'id'    => $api['id'],
                        'cid'   => $item['id'],
                        'name'  => $api['name'],
                        'type'  => 'api',
                        'key'   => 'api_'.$api['id'],
                    ];
                }
                $return[$k] = [
                    'id'        => $item['id'],
                    'name'      => $item['name'],
                    'type'      => 'cat',
                    'key'       => 'cat_'.$item['id'],
                    'children'  => $apis ?? [],
                ];
                unset($apis);
            }else{
                $return[$k] = [
                    'id'    => $item['id'],
                    'name'  => $item['name'],
                    'type'  => 'cat',
                    'key'   => 'cat_'.$item['id'],
                ];
            }
        }
        return $return;
    }

    /**
     * 更新路径信息
     */
    public static function updateReqParam($aid,$params){
        ApiReqParam::where(['aid'=>$aid])->delete();
        if(is_array($params) && !empty($params)){
            $arr = [];
            foreach ($params as $item){
                if($item['name']){
                    $arr[] = [
                        'aid'        => $aid,
                        'name'       => $item['name'],
                        'value'      => $item['value'],
                        'desc'       => $item['desc'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            !empty($arr) && ApiReqParam::insert($arr);
        }
    }

    /**
     * 更新查询信息
     */
    public static function updateReqQuery($aid,$params){
        ApiReqQuery::where(['aid'=>$aid])->delete();
        if(is_array($params) && !empty($params)){
            $arr = [];
            foreach ($params as $item){
                if($item['name']){
                    $arr[] = [
                        'aid'        => $aid,
                        'name'       => $item['name'],
                        'required'   => $item['required'],
                        'datatype'   => $item['datatype'],
                        'value'      => $item['value'],
                        'desc'       => $item['desc'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            !empty($arr) && ApiReqQuery::insert($arr);
        }
    }

    /**
     * 更新请求头信息
     */
    public static function updateReqHeader($aid,$params){
        ApiReqHeader::where(['aid'=>$aid])->delete();
        if(is_array($params) && !empty($params)){
            $arr = [];
            foreach ($params as $item){
                if($item['name']){
                    $arr[] = [
                        'aid'        => $aid,
                        'name'       => $item['name'],
                        'value'      => $item['value'],
                        'desc'       => $item['desc'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                }
            }
            !empty($arr) && ApiReqHeader::insert($arr);
        }
    }

    /**
     * 更新请求主体
     */
    public static function updateReqBody($aid,$body_type,$body_form,$body_json){
        ApiReqBodyForm::where(['aid'=>$aid])->delete();
        ApiReqBodyJson::where(['aid'=>$aid])->delete();
        if($body_type == 'form'){
            if(is_array($body_form) && !empty($body_form)){
                $arr = [];
                foreach ($body_form as $item){
                    if($item['name']){
                        $arr[] = [
                            'aid'        => $aid,
                            'name'       => $item['name'],
                            'required'   => $item['required'],
                            'datatype'   => $item['datatype'],
                            'value'      => $item['value'],
                            'desc'       => $item['desc'],
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                }
                !empty($arr) && ApiReqBodyForm::insert($arr);
            }
        }elseif ($body_type == 'json'){
            self::addReqBodyJson($aid,$body_json);
        }else{
            // 没有body数据
        }
    }

    /**
     * 递归增加数据
     */
    public static function addReqBodyJson($aid,$data=[],$fid=0){
        if(is_array($data) && !empty($data)){
            foreach ($data as $item){
                if($item['name']){
                    $arr = [
                        'aid'        => $aid,
                        'fid'        => $fid,
                        'name'       => $item['name'],
                        'required'   => $item['required'],
                        'datatype'   => $item['datatype'],
                        'value'      => $item['value'],
                        'desc'       => $item['desc'],
                    ];
                    $rs = ApiReqBodyJson::create($arr);
                    if(!empty($item['children'])){
                        self::addReqBodyJson($aid,$item['children'],$rs->id);
                    }
                }
            }
        }
    }

    /**
     * 更新返回信息
     */
    public static function updateResBody($aid,$body){
        ApiResBody::where(['aid'=>$aid])->delete();
        self::addResBody($aid,$body);
    }


    /**
     * 递归增加数据
     */
    public static function addResBody($aid,$data=[],$fid=0){
        if(is_array($data) && !empty($data)){
            foreach ($data as $item){
                if($item['name']){
                    $arr = [
                        'aid'        => $aid,
                        'fid'        => $fid,
                        'name'       => $item['name'],
                        'required'   => $item['required'],
                        'datatype'   => $item['datatype'],
                        'value'      => $item['value'],
                        'desc'       => $item['desc'],
                    ];
                    $rs = ApiResBody::create($arr);
                    if(!empty($item['children'])){
                        self::addResBody($aid,$item['children'],$rs->id);
                    }
                }
            }
        }
    }



}
