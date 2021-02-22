<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Utils\RedisDB;

class ParkIndex extends BaseAction
{
    protected  $_checkLogin = true;
    protected  $_needLogin = true;

    public function index(){

        $_redis = new RedisDB();
//        $_redis->set('key','123');
        $data = $_redis->get('key');
        return $this->success(['data' =>$data ]);
    }
}