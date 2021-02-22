<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Common\ParkCommon;
use app\Service\Park\ParkService;
use app\Utils\Map;

class ShareParkSearch extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index()
    {
        $_parkService = new ParkService();

        $address = $this->_getInput('address','北京市海淀区彩和坊路海淀西大街74号');
        if(empty($address)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }
        //调用逆地址解析获取经纬度
        $ret = ParkCommon::addressResolution($address);

        return $this->success([
            'position' => $ret,
        ]);
    }
}