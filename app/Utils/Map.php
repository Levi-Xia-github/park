<?php
/**
 * 腾讯地点云存储、云搜索
 */
class  Common_Map{


    /**
     * 开发者密钥
     */
    public static $_key = 'OGTBZ-QETCP-VSID7-VJIKR-RRPM3-UBFAO';
    public static $_table_id = '5ff58e5b099cfa6e0bdf6f6a';

    /**
     * 云存储
     * 文档 https://lbs.qq.com/service/placeCloud/placeCloudGuide/cloudDataManage
     */
    public static function listCloudDataManage($output='json',$callback=''){
        $data['key'] = self::$_key;
        $data['table_id'] = self::$_table_id;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;
        $ret = Common_Curl::get("https://apis.map.qq.com/place_cloud/table/list",$data);
        return $ret;
    }

    /**
     * 创建数据（create）接口
     * 文档 https://lbs.qq.com/service/placeCloud/placeCloudGuide/cloudDataManage
     */
    public static function createCloudDataManage($dataArr){
        if(empty($dataArr)){
            throw new BBT_Error(BBT_ErrorCodes::PARAM_ERROR);
        }
        $dataArr1[] = 
        [
            "ud_id" => "156985",
            "title" => "xxx",
            "address" => "xxx",
            "location" => [
                "lat" => 39.983988,
                "lng" => 116.307709
            ],
            "x" => "",             
        ];
        $data['data'] = $dataArr1;
        $data['key'] = self::$_key;
        $data['table_id'] = self::$_table_id;

        $ret = Common_Curl::post("https://apis.map.qq.com/place_cloud/data/create",$data);
        return $ret;
    }

    /**
     * 数据列表
     * 文档 https://lbs.qq.com/service/placeCloud/placeCloudGuide/cloudDataManage
     */
    public static function listDataCloudDataManage($fields='',$orderby='id desc',$page_size='',$page_index='',$output='json',$callback=''){
        $data['key'] = self::$_key;
        $data['table_id'] = self::$_table_id;
        !empty($fields) && $data['fields'] = $fields;
        !empty($orderby) && $data['orderby'] = $orderby;
        !empty($page_size) && $data['page_size'] = $page_size;
        !empty($page_index) && $data['page_index'] = $page_index;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;
        $ret = Common_Curl::get("https://apis.map.qq.com/place_cloud/data/list",$data);
        return $ret;
    }

}