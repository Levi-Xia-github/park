<?php

namespace app\Service\Park;

use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Base\BaseService;
use app\Dao\Park\ParkDao;

class ParkService extends BaseService
{
    public $_daoPark = Null;

    public function __construct()
    {
        $this->_daoPark = new ParkDao();
    }

    public function getShareParkForBk(){
        $ret = $this->_daoPark->getShareParkForBk(0,20);
        return $ret;
    }

    public function addShareParkForBk($address,$desc,$longitude,$latitude,$picList,$price,$remark,$facePic,$exact){
        if(empty($address) || empty($longitude) || empty(($latitude) || empty($picList) || $price) || empty($remark) || empty($facePic) || empty($desc)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        $shareParkInfo = [
            'address' => $address,
            'desc' =>  $desc,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'exact' => $exact,
            'facePic' => $facePic,
            'picList' => $picList,
            'price' => $price,
            'remark' => $remark,
            'createTime' => time(),
            'updateTime' => time(),
        ];
        $ret = $this->_daoPark->addShareParkForBk($shareParkInfo);
        return $ret;
    }
}