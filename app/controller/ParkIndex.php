<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Common\ParkCommon;
use app\Service\Park\ParkService;
use app\Service\Search\SearchService;
use app\Service\User\UserService;
use app\Utils\RedisDB;

class ParkIndex extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index(){

        return $this->index2();
        $_parkService = new ParkService();
        $_userService = new UserService();

        $_redis = new RedisDB();

        $longitude = $this->_getInput('longitude','116.39513');
        $latitude = $this->_getInput('latitude','39.867611');
        $isEnd = $this->_getInput('isEnd',false);
        $page = $this->_getInput('page',1);
        $range = $this->_getInput('range','2000');

        if(empty($longitude) || empty($latitude)){
            throw new BaseException(BaseErrorCode::POSITION_FAILED);
        }
        //每次取三十个
        $num = 20;
        $shareParkSpaceList = [];

        //从redis获取当前位置附近车位
        $data = $_redis->geoRadius('shareparkspace',$longitude,$latitude,$range,'km','WITHCOORD','ASC');
        $data = ParkCommon::redisGeoDataFormat($data);

        //车位坐标列表
        $positionPointList = array_column($data,'position');
        $shareParkSpaceIdList = array_column($data,'id');
//        $shareParkSpaceIdList = array_slice($shareParkSpaceIdList, ($page-1)*$limit , $limit);

        if(!empty($shareParkSpaceIdList)){
            $shareParkSpaceList = $_parkService->getShareParkByIdList($shareParkSpaceIdList);
        }

        //计算当前位置与此位置的距离
        foreach ($shareParkSpaceList as &$value){
            $value['geoDist'] = ParkCommon::getDistanceOfTwoPosition($latitude,$longitude,$value['latitude'],$value['longitude']);
        }
        unset($value);

        return $this->success([
//            'redisData' => $data,
            'positionPointList' => $positionPointList,
            'shareParkSpaceList' => $shareParkSpaceList,
        ]);
    }

    public function index2(){
        $_parkService = new ParkService();
        $_userService = new UserService();
        $_searchService = new SearchService();

        $longitude = $this->_getInput('longitude','116.39513');
        $latitude = $this->_getInput('latitude','39.867611');
        $isEnd = $this->_getInput('isEnd',false);
        $boundaryId = $this->_getInput('boundaryId',0);
        $distance = $this->_getInput('distance',100000);

        if(empty($longitude) || empty($latitude) || empty($distance)){
            throw new BaseException(BaseErrorCode::POSITION_FAILED);
        }
        //每次取二十个
        $num = 20;

        //从es获取当前位置附近车位
       $esResponse = $_searchService->getParkList($distance,$latitude,$longitude,$boundaryId,$num);
       return $this->success([$esResponse]);

        //车位坐标列表
        $shareParkSpaceIdList = $esResponse['spaceIdList'] ?? [];
        $spaceLocationList = $esResponse['spaceLocationList'] ?? [];
        $boundaryId = $esResponse['boundaryId'];
        $isEnd = $esResponse['isEnd'];

        $shareParkSpaceList = [];
        if(!empty($shareParkSpaceIdList)){
            $shareParkSpaceList = $_parkService->getShareParkByIdList($shareParkSpaceIdList);
        }

        //计算当前位置与此位置的距离
        foreach ($shareParkSpaceList as &$value){
            $value['geoDist'] = ParkCommon::getDistanceOfTwoPosition($latitude,$longitude,$value['latitude'],$value['longitude']);
        }
        unset($value);

        return $this->success([
            'boundaryId' => $boundaryId,
            'isEnd' => $isEnd,
            'spaceLocationList' => $spaceLocationList,
            'shareParkSpaceList' => $shareParkSpaceList,
        ]);
    }
}