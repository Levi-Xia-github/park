<?php


namespace app\controller;


use app\Base\BaseAction;

class ViewCtrl extends BaseAction
{
    public function index(){
        $data = [
            'name' => '张三',
            'age' => 18,
        ];
        return $this->buildOutput('index/index',$data);
    }

}