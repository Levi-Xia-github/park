<?php


namespace app\controller;

use app\Base\BaseAction;
use app\Utils\RedisDB;

class Test extends BaseAction
{
    public function index(){
        $redis = new RedisDB();

        return $redis->get('key');

    }
}