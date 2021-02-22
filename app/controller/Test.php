<?php


namespace app\controller;

use app\Base\BaseAction;
use app\Common\ParkCommon;
use app\Utils\Map;
use app\Utils\RedisDB;
use think\facade\Config;

class Test extends BaseAction
{
    public function index(){
        $redis = new RedisDB();
//        $redis->set('key',888);
//        return $redis->get('key');

//        $redis->flushAll();
//        die();

        //测试插入redis 地图数据
//        $redis->geoAdd('shareparkspace','116.407013','39.887611','100000000');
//        $redis->geoAdd('shareparkspace','116.422119','39.909736','100000001');
//        $redis->geoAdd('shareparkspace','116.408386','39.900255','100000002');
//        $redis->geoAdd('shareparkspace','116.516876','39.711413','100000003');

        return json(ParkCommon::getDistanceOfTwoPosition('39.887611','116.407013','39.900255','116.408386'));
    }
}