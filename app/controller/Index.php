<?php


namespace app\controller;


use app\Base\BaseAction;

class Index extends BaseAction
{
    public function index(){

        return $this->success(
            [
                '欢迎来到我的环境'
            ]
        );
    }
}