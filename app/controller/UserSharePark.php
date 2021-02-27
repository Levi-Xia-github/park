<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Base\BaseErrorCode;
use app\Base\BaseException;
use app\Service\Park\ParkService;
use app\Service\User\UserService;

class UserSharePark extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index(){
        $_parkService = new ParkService();
        $_userService = new UserService();

        $userId = $this->_userId;
        $orderTime= time();
        $spaceId = $this->_getInput('spaceId',0);

        if(empty($userId) || empty($spaceId)){
            throw new BaseException(BaseErrorCode::PARAM_ERROR);
        }

        //查看当前用户是否有共享类订单

        //验证当前车位是否满足状态

        //开启车位 写入订单

        //将共享订单订单信息和用户关联存入redis

    }
}