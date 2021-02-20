<?php

namespace app\Utils;

/**
 * 腾讯地点云存储、云搜索
 */
/**
 * api 腾讯地图服务
 * 地点搜索
 * 逆地址解析
 * 地址解析
 * 路线规划
 * 批量计算距离
 * 行政区划
 * 坐标转换
 * IP定位
 */
class  Map{


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
        $ret = Curl::get("https://apis.map.qq.com/place_cloud/table/list",$data);
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

        $ret = Curl::post("https://apis.map.qq.com/place_cloud/data/create",$data);
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
        $ret = Curl::get("https://apis.map.qq.com/place_cloud/data/list",$data);
        return $ret;
    }

    /**
     * 逆地址解析
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceGcoder
     */
    public static function  reverseAddressResolution($location,$output='json',$get_poi=0,$poi_options='',$callback=''){
        if(empty($location)){
            throw new BBT_Error(BBT_ErrorCodes::PARAM_ERROR);
        }
        // $data['location'] = $location;
        //location直接写到url里,不然会被转义逗号
        $data['key'] = self::$_key;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;
        !empty($get_poi) && $data['get_poi'] = $get_poi;
        !empty($poi_options) && $data['poi_options'] = $poi_options;

        $ret = Curl::get('https://apis.map.qq.com/ws/geocoder/v1/?location='.$location , $data);
        return $ret;
    }
    /**
     * 地址解析
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceGeocoder
     */
    public static function addressResolution($address,$region='',$output='json',$callback=''){
        if(empty($address)){
            throw new BBT_Error(BBT_ErrorCodes::PARAM_ERROR);
        }
        $data['address'] = $address;
        $data['key'] = self::$_key;
        !empty($region) && $data['region'] = $region;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;

        $ret = Curl::get('https://apis.map.qq.com/ws/geocoder/v1/',$data);
        return $ret;
    }

    /**
     * 行政区划 -- 全部省市区三级行政区划
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceDistrict
     */
    public static function administrativeDivisions($output='json',$callback=''){
        $data['key'] = self::$_key;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;

        $ret = Curl::get('http://apis.map.qq.com/ws/district/v1/list',$data);
        return $ret;
    }

    /**
     * 获取指定行政区划的子级行政区划
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceDistrict
     */
    public static function LowerAdministrativeDivisions($id='',$get_polygon=0,$max_offset='',$output='json',$callback=''){
        $data['key'] = self::$_key;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;
        !empty($id) && $data['id'] = $id;
        !empty($get_polygon) && $data['get_polygon'] = $get_polygon;
        !empty($max_offset) && $data['max_offset'] = $max_offset;

        $ret = Curl::get('http://apis.map.qq.com/ws/district/v1/getchildren',$data);
        return $ret;
    }

    /**
     * 根据关键词或行政区划代码搜索
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceDistrict
     */
    public static function searchAdministrativeDivisions($keyword,$get_polygon=0,$max_offset='',$output='json',$callback=''){
        if(empty($keyword)){
            throw new BBT_Error(BBT_ErrorCodes::PARAM_ERROR);
        }
        $data['key'] = self::$_key;
        $data['keyword'] = $keyword;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;
        !empty($get_polygon) && $data['get_polygon'] = $get_polygon;
        !empty($max_offset) && $data['max_offset'] = $max_offset;

        $ret = Curl::get('http://apis.map.qq.com/ws/district/v1/search',$data);
        return $ret;
    }

    /**
     * IP定位
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceIp
     * 精确到市级
     * 常用于显示当地城市天气预报、初始化用户城市等非精确定位场景
     */
    public static function IpPositioning($ip='',$output='json',$callback=''){
        $data['key'] = self::$_key;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;

        $ret = Curl::get('https://apis.map.qq.com/ws/location/v1/ip',$data);
        return $ret;
    }

    /**
     * 关键词输入提示
     * 文档 https://lbs.qq.com/service/webService/webServiceGuide/webServiceSuggestion
     */
    public static function keyWorkSuggestion($keyword,$region,$region_fix=0,$location='',$get_subpois=0,$policy=0,$filter='',$address_format='',$page_index='',$page_size='',$output='json',$callback=''){
        if(empty($keyword) || empty($region)){
            throw new BBT_Error(BBT_ErrorCodes::PARAM_ERROR);
        }
        $data['key'] = self::$_key;
        $data['keyword'] = $keyword;
        $data['region'] = $region;
        !empty($region_fix) && $data['region_fix'] = $region_fix;
        !empty($get_subpois) && $data['get_subpois'] = $get_subpois;
        !empty($policy) && $data['policy'] = $policy;
        !empty($filter) && $data['filter'] = $filter;
        !empty($address_format) && $data['address_format'] = $address_format;
        !empty($page_index) && $data['page_index'] = $page_index;
        !empty($page_size) && $data['page_size'] = $page_size;
        !empty($output) && $data['output'] = $output;
        !empty($callback) && $data['callback'] = $callback;

        $url = 'https://apis.map.qq.com/ws/place/v1/suggestion';
        if(!empty($location)){
            $url .= '?location='.$location;
        }
        $ret = Curl::get($url,$data);
        return $ret;
    }

}