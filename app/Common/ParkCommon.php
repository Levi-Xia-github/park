<?php


namespace app\Common;


use app\Utils\Map;

class ParkCommon
{
    public static function getBlog($blogId){

    }

    public static function getUserInfoByUserId($userId){

    }

    /**
     * geo数据返回数据格式化
     */
    public static function redisGeoDataFormat($data){
        $output = [];
        foreach ($data as $k => $d){
            $output[$k]['id'] = $d[0];
            $output[$k]['position'] = $d[1];
        }
        return $output;
    }

    /**
     * 计算两个坐标之间的距离和时间
     */
    public static function getDistanceOfTwoPosition($latitude1,$longitude1,$latitude2,$longitude2,$mode='driving'){
        $from = $latitude1 . ','. $longitude1 ;
        $to = $latitude2 . ',' . $longitude2 ;
        $ret = Map::distanceOfTwoPosition($mode,$from,$to);
        $array = json_decode(json_encode($ret),TRUE);

        //需要做校验 //TODO

        return $array['result']['rows'][0]['elements'][0] ?? ['distance' => 0 , 'duration' => 0];
    }

    /**
     * 逆地址解析获取经纬度
     */
    public static function addressResolution($address)
    {
        $ret = Map::addressResolution($address);
        $array = json_decode(json_encode($ret), TRUE);

        return $array['result']['location'] ?? ['lng' => 0 , 'lat' => 0];
    }

}